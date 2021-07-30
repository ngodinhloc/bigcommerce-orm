<?php
declare(strict_types=1);

namespace Bigcommerce\ORM;

use Bigcommerce\ORM\Client\ClientInterface;
use Bigcommerce\ORM\Entities\PaymentAccessToken;
use Bigcommerce\ORM\Events\EntityManagerEvent;
use Bigcommerce\ORM\Exceptions\EntityException;
use Bigcommerce\ORM\Relation\RelationInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class EntityManager
 * @package Bigcommerce\ORM
 */
class EntityManager
{
    /** @var \Bigcommerce\ORM\Client\ClientInterface */
    protected $client;

    /** @var \Bigcommerce\ORM\Mapper */
    protected $mapper;

    /** @var \Symfony\Component\EventDispatcher\EventDispatcherInterface */
    protected $eventDispatcher;

    /**
     * EntityManager constructor.
     *
     * @param \Bigcommerce\ORM\Client\ClientInterface $client
     * @param \Bigcommerce\ORM\Mapper|null $mapper
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface|null $eventDispatcher
     */
    public function __construct(ClientInterface $client, ?Mapper $mapper = null, ?EventDispatcherInterface $eventDispatcher = null)
    {
        $this->client = $client;
        $this->mapper = $mapper ?: new Mapper();
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Find all object of a class name
     *
     * @param string $className
     * @param array|null $pathParams
     * @param array|null $order
     * @param bool $auto auto loading
     * @return array|bool
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function findAll(string $className, ?array $pathParams = null, ?array $order = null, bool $auto = false)
    {
        $entity = $this->getPatchedEntity($className, $pathParams);
        $resourcePath = $this->mapper->getResourcePath($entity);
        $resourceType = $entity->getMetadata()->getResource()->type;
        $autoIncludes = $entity->getMetadata()->getIncludeFields();

        $queryBuilder = new QueryBuilder();
        if (!empty($order)) {
            $queryBuilder->order($order);
        }
        $queryString = $queryBuilder->include(array_keys($autoIncludes))->getQueryString();
        $result = $this->client->findAll($resourcePath . "?" . $queryString, $resourceType);

        return $this->arrayToCollection($result, $className, $pathParams, $auto);
    }

    /**
     * Query objects by conditions
     *
     * @param string $className
     * @param array|null $pathParams
     * @param \Bigcommerce\ORM\QueryBuilder|null $queryBuilder
     * @param bool $auto
     * @return array|false
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function findBy(string $className, ?array $pathParams = null, ?QueryBuilder $queryBuilder = null, $auto = false)
    {
        $entity = $this->getPatchedEntity($className, $pathParams);
        $resourcePath = $this->mapper->getResourcePath($entity);
        $resourceType = $entity->getMetadata()->getResource()->type;
        $autoIncludes = $entity->getMetadata()->getIncludeFields();
        $queryString = $queryBuilder->include(array_keys($autoIncludes))->getQueryString();
        $result = $this->client->findBy($resourcePath . "?" . $queryString, $resourceType);

        return $this->arrayToCollection($result, $className, $pathParams, $auto);
    }

    /**
     * @param string $className
     * @param int|string $id
     * @param array|null $pathParams
     * @param bool $auto
     * @return \Bigcommerce\ORM\AbstractEntity|false
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws Exceptions\MapperException
     */
    public function find(string $className, $id, ?array $pathParams = null, bool $auto = false)
    {
        $entity = $this->getPatchedEntity($className, $pathParams);
        $resourcePath = $this->mapper->getResourcePath($entity, 'find');
        $resourceType = $entity->getMetadata()->getResource()->type;
        $autoIncludes = $entity->getMetadata()->getIncludeFields();

        $queryBuilder = new QueryBuilder();
        $query = $queryBuilder->include(array_keys($autoIncludes))->getQueryString();
        $result = $this->client->find($resourcePath . "/{$id}?" . $query, $resourceType);
        if (empty($result)) {
            return false;
        }

        $entity = $this->mapper->patch($entity, $result, $pathParams, false);
        if ($auto == false) {
            return $entity;
        }

        if (empty($entity->getMetadata()->getAutoLoadFields())) {
            return $entity;
        }

        return $this->autoLoad($entity, $result, $pathParams);
    }

    /**
     * Save entity
     * If id is provided: update entity
     * No id provided: create entity
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity entity
     * @return bool
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     */
    public function save(AbstractEntity $entity)
    {
        $this->mapper->checkEntity($entity);
        if ($entity->isPatched() !== true) {
            $entity = $this->mapper->patch($entity, [], null, true);
        }

        $this->checkBeforeCreating($entity);
        $writableData = $this->mapper->getWritableFieldValues($entity);

        /** if id provided then update entity */
        if (!empty($id = $entity->getId())) {
            return $this->updateEntity($entity, $writableData);
        }

        /** if no id provided then create entity */
        return $this->createEntity($entity, $writableData);
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @return bool
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     */
    public function create(AbstractEntity $entity)
    {
        $this->mapper->checkEntity($entity);

        if ($entity->isPatched() !== true) {
            $entity = $this->mapper->patch($entity, [], null, true);
        }

        $this->checkBeforeCreating($entity);
        $writableData = $this->mapper->getWritableFieldValues($entity);

        return $this->createEntity($entity, $writableData);
    }

    /**
     * Update entity with array of data: only the fields in data will be sent to server for updating
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param array|null $data
     * [fieldName => value]
     * @return bool
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function update(AbstractEntity $entity, ?array $data = [])
    {
        $this->mapper->checkEntity($entity);
        $this->mapper->checkId($entity->getId());

        if (empty($data)) {
            return true;
        }

        if ($entity->isPatched() !== true) {
            $entity = $this->mapper->patch($entity, [], null, true);
        }

        if (!$this->mapper->checkFieldValues($data)) {
            return true;
        }

        $this->checkBeforeUpdating($entity);
        $writableData = $this->mapper->getWritableFieldValues($entity, $data);

        return $this->updateEntity($entity, $writableData);
    }

    /**
     * Delete multiple entities
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param string|null $paramField
     * @return bool
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function delete(AbstractEntity $entity, ?string $paramField = 'id')
    {
        if (empty($paramField)) {
            $paramField = 'id';
        }

        $resourcePath = $this->mapper->getResourcePath($entity, 'delete');
        $resourceType = $entity->getMetadata()->getResource()->type;
        $fieldValue = $this->mapper->getEntityReader()->getPropertyValueByFieldName($entity, $paramField);
        if (empty($fieldValue)) {
            throw new EntityException(EntityException::ERROR_EMPTY_PARAM_FIELD . $paramField);
        }

        $result = $this->client->delete($resourcePath . '/' . $fieldValue, $resourceType);
        if(!empty($result)) {
            if ($this->hasEventDispatcher()) {
                $this->eventDispatcher->dispatch(
                    EntityManagerEvent::ENTITY_DELETED,
                    new EntityManagerEvent(EntityManagerEvent::ENTITY_DELETED, $entity)
                );
            }

            return true;
        }

        return false;
    }

    /**
     * Create multiple entities of the same class. Batch create does not upload files
     *
     * @param array|\Bigcommerce\ORM\AbstractEntity[] $entities
     * @param array|null $pathParams
     * @return array|bool
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function batchCreate(?array $entities = null, ?array $pathParams = null)
    {
        if (empty($entities)) {
            return false;
        }

        $entity = current($entities);
        $className = get_class($entity);
        $entity = $this->mapper->patch($entity, [], $pathParams, true);
        $resourcePath = $this->mapper->getResourcePath($entity);
        $resourceType = $entity->getMetadata()->getResource()->type;
        $data = $this->getBatchCreateData($className, $entities);

        $result = $this->client->create($resourcePath, $resourceType, $data, null, true);
        if (!empty($result)) {
            return $this->getCreatedEntities($className, $result, $pathParams);
        }

        return false;
    }

    /**
     * Update multiple entities of the same class. Batch update does not upload files
     *
     * @param array|\Bigcommerce\ORM\AbstractEntity[] $entities
     * @param array|null $pathParams
     * @return array|false
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function batchUpdate(?array $entities = null, ?array $pathParams = null)
    {
        $entity = current($entities);
        $className = get_class($entity);
        $entity = $this->mapper->patch($entity, [], $pathParams, true);
        $resourcePath = $this->mapper->getResourcePath($entity);
        $resourceType = $entity->getMetadata()->getResource()->type;
        $data = $this->getBatchUpdateData($className, $entities);

        $result = $this->client->update($resourcePath, $resourceType, $data, null, true);
        if (!empty($result)) {
            return $this->getUpdatedEntities($entities, $result, $pathParams);
        }

        return false;
    }

    /**
     * Delete multiple entities
     *
     * @param string $className
     * @param array|null $pathParams
     * @param array|null $values
     * @param string|null $field
     * @return array|bool
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function batchDelete(string $className, ?array $pathParams = null, ?array $values = null, ?string $field = 'id')
    {
        if (empty($values)) {
            return false;
        }

        if (empty($field)) {
            $field = 'id';
        }

        $entity = $this->getPatchedEntity($className, $pathParams);
        $resourcePath = $this->mapper->getResourcePath($entity, 'delete');
        $resourceType = $entity->getMetadata()->getResource()->type;
        $queryBuilder = new QueryBuilder();
        $query = $queryBuilder->whereIn($field, array_values($values))->getQueryString();

        return $this->client->delete($resourcePath . "?" . $query, $resourceType);
    }

    /**
     * Create an entity from data
     *
     * @param string $class
     * @param array|null $data
     * @param array|null $pathParams
     * @return \Bigcommerce\ORM\AbstractEntity
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function new(string $class, ?array $data = null, ?array $pathParams = null)
    {
        $this->mapper->checkClass($class);
        $object = $this->mapper->object($class);

        return $this->mapper->patch($object, $data, $pathParams, false);
    }

    /**
     * Patch entity with data array
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param array|null $data
     * @param array|null $pathParams
     * @return \Bigcommerce\ORM\AbstractEntity
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function patch(AbstractEntity $entity, ?array $data = null, array $pathParams = null)
    {
        return $this->mapper->patch($entity, $data, $pathParams, false);
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param int $key
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @see \Bigcommerce\ORM\Mapper::KEY_BY_FIELD_NAME
     * @see \Bigcommerce\ORM\Mapper::KEY_BY_PROPERTY_NAME
     */
    public function toArray(AbstractEntity $entity, int $key = Mapper::KEY_BY_FIELD_NAME)
    {
        return $this->mapper->toArray($entity, $key);
    }

    /**
     * @param string $className
     * @param array|null $pathParams
     * @return \Bigcommerce\ORM\AbstractEntity
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function getPatchedEntity(string $className, ?array $pathParams = null)
    {
        $this->mapper->checkClass($className);
        $object = $this->mapper->object($className);

        return $this->mapper->patch($object, [], $pathParams, true);
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function checkBeforeCreating(AbstractEntity $entity)
    {
        if ($entity->isPaymentAccessTokenRequired()) {
            if(empty($paymentAccessToken = $entity->getPaymentAccessToken())){
                throw new EntityException(EntityException::ERROR_PAYMENT_ACCESS_TOKEN_REQUIRED);
            }
            $this->setPaymentAccessToken($paymentAccessToken);
        }

        $checkRequiredProperties = $this->mapper->checkRequiredFields($entity);
        if ($checkRequiredProperties !== true) {
            throw new EntityException(EntityException::ERROR_REQUIRED_PROPERTIES . implode(", ", $checkRequiredProperties));
        }

        $checkRequiredValidations = $this->mapper->checkRequiredValidations($entity);
        if ($checkRequiredValidations !== true) {
            throw new EntityException(EntityException::ERROR_REQUIRED_VALIDATIONS . implode(", ", $checkRequiredValidations));
        }
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function checkBeforeUpdating(AbstractEntity $entity)
    {
        $checkRequiredValidations = $this->mapper->checkRequiredValidations($entity);
        if ($checkRequiredValidations !== true) {
            throw new EntityException(EntityException::ERROR_REQUIRED_VALIDATIONS . implode(", ", $checkRequiredValidations));
        }
    }

    /**
     * @param string $className
     * @param \Bigcommerce\ORM\AbstractEntity[]|null $entities
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function getBatchCreateData(string $className, ?array $entities = null)
    {
        $data = [];
        foreach ($entities as $entity) {
            if ($className != get_class($entity)) {
                throw new EntityException(EntityException::ERROR_DIFFERENT_CLASS_NAME);
            }

            $this->checkBeforeCreating($entity);
            $writableData = $this->mapper->getWritableFieldValues($entity);
            $data[] = $writableData;
        }

        return $data;
    }

    /**
     * @param string $className
     * @param \Bigcommerce\ORM\AbstractEntity[]|null $entities
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function getBatchUpdateData(string $className, ?array &$entities = null)
    {
        $data = [];
        foreach ($entities as $entity) {
            if ($className != get_class($entity)) {
                throw new EntityException(EntityException::ERROR_DIFFERENT_CLASS_NAME);
            }

            if (empty($entity->getId())) {
                continue;
            }

            $this->checkBeforeUpdating($entity);
            $writableData = $this->mapper->getWritableFieldValues($entity);
            $entities[$entity->getId()] = $entity;
            $data[] = array_merge($writableData, ['id' => $entity->getId()]);
        }

        return $data;
    }

    /**
     * @param string $className
     * @param array|null $result
     * @param array|null $pathParams
     * @return array|bool
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function getCreatedEntities(string $className, ?array $result = null, ?array $pathParams = null)
    {
        $entities = [];
        foreach ($result as $item) {
            if (isset($item['id'])) {
                $entities[] = $this->new($className, $item, $pathParams);
            } else {
                return true;
            }
        }

        return $entities;
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity[]|null $entities
     * @param array|null $result
     * @param array|null $pathParams
     * @return array|bool
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function getUpdatedEntities(?array $entities = null, ?array $result = null, ?array $pathParams = null)
    {
        $output = [];
        foreach ($result as $data) {
            if (isset($data['id']) && isset($entities[$data['id']])) {
                $entity = $entities[$data['id']];
                $output[] = $this->mapper->patch($entity, $data, $pathParams, false);
            } else {
                return true;
            }
        }

        return $output;
    }

    /**
     * @param array|null $array
     * @param string|null $className
     * @param array|null $pathParams
     * @param bool $auto
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function arrayToCollection(?array $array = null, ?string $className = null, ?array $pathParams = null, bool $auto = false)
    {
        $collections = [];

        if (!empty($array)) {
            foreach ($array as $item) {
                $object = $this->mapper->object($className);
                $relationEntity = $this->mapper->patch($object, $item, $pathParams, false);

                if ($auto == false) {
                    $collections[] = $relationEntity;
                } else {
                    if (empty($relationEntity->getMetadata()->getAutoLoadFields())) {
                        $collections[] = $relationEntity;
                    } else {
                        $collections[] = $this->autoLoad($relationEntity, $item, $pathParams);
                    }
                }
            }
        }

        return $collections;
    }

    /**
     * Load object in relations
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param array|null $data
     * @param array|null $pathParams
     * @return \Bigcommerce\ORM\AbstractEntity
     */
    private function autoLoad(AbstractEntity $entity, ?array $data = null, ?array $pathParams = null)
    {
        if (empty($entity->getMetadata()->getAutoLoadFields())) {
            return $entity;
        }

        foreach ($entity->getMetadata()->getAutoLoadFields() as $fieldName => $load) {
            $property = $load['property'];
            $annotation = $load['annotation'];

            if ($annotation instanceof RelationInterface) {
                $handler = $annotation->getHandler($this);
                $handler->handle($entity, $property, $annotation, $data, $pathParams);
            }
        }

        return $entity;
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param array|null $data
     * @return bool
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function createEntity(AbstractEntity $entity, array $data = null)
    {
        if (!$this->mapper->checkFieldValues($data)) {
            throw new EntityException(EntityException::ERROR_EMPTY_PROPERTY_VALUES);
        }

        $resourcePath = $this->mapper->getResourcePath($entity, 'create');
        $resourceType = $entity->getMetadata()->getResource()->type;
        $files = $this->getUploadFiles($entity);

        $result = $this->client->create($resourcePath, $resourceType, $data, $files);
        if (!empty($result)) {
            $this->mapper->patch($entity, $result, null, false);
            $this->mapper->getEntityReader()->setPropertyValueByName($entity, 'isNew', true);

            if ($this->hasEventDispatcher()) {
                $this->eventDispatcher->dispatch(
                    EntityManagerEvent::ENTITY_CREATED,
                    new EntityManagerEvent(EntityManagerEvent::ENTITY_CREATED, $entity)
                );
            }

            return true;
        }

        return false;
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param array|null $data
     * @return bool
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    private function updateEntity(AbstractEntity $entity, array $data = null)
    {
        if (!$this->mapper->checkFieldValues($data)) {
            return true;
        }

        $resourcePath = $this->mapper->getResourcePath($entity, 'update');
        $resourceType = $entity->getMetadata()->getResource()->type;
        $files = $this->getUploadFiles($entity);

        $result = $this->client->update($resourcePath . "/{$entity->getId()}", $resourceType, $data, $files);
        if (!empty($result)) {
            if (isset($result['id']) && $result['id'] == $entity->getId()) {
                $this->mapper->patch($entity, $result, null, false);
            }
            $this->mapper->getEntityReader()->setPropertyValueByName($entity, 'isNew', false);

            if ($this->hasEventDispatcher()) {
                $this->eventDispatcher->dispatch(
                    EntityManagerEvent::ENTITY_UPDATED,
                    new EntityManagerEvent(EntityManagerEvent::ENTITY_UPDATED, $entity)
                );
            }

            return true;
        }

        return false;
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    private function getUploadFiles(AbstractEntity $entity)
    {
        $files = [];
        if (!empty($uploadFields = $entity->getMetadata()->getUploadFields())) {
            foreach ($uploadFields as $fieldName => $property) {
                $location = $this->mapper->getEntityReader()->getPropertyValue($entity, $property);
                if (!empty($location)) {
                    if (!file_exists($location)) {
                        throw new EntityException(EntityException::ERROR_INVALID_UPLOAD_FILE . $location);
                    }

                    $files[$fieldName] = $location;
                }
            }
        }

        return $files;
    }

    /**
     * @return bool
     */
    private function hasEventDispatcher()
    {
        return ($this->eventDispatcher instanceof EventDispatcherInterface);
    }

    /**
     * @param string $className
     * @return \Bigcommerce\ORM\Repository
     * @throws \Exception
     */
    public function getRepository(string $className)
    {
        $repository = new Repository($this);
        $repository->setClassName($className);

        return $repository;
    }

    /**
     * @return \Bigcommerce\ORM\Mapper
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * @param \Bigcommerce\ORM\Mapper|null $mapper
     * @return \Bigcommerce\ORM\EntityManager
     */
    public function setMapper(?Mapper $mapper = null)
    {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Client\ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param \Bigcommerce\ORM\Client\ClientInterface|null $client
     * @return \Bigcommerce\ORM\EntityManager
     */
    public function setClient(?ClientInterface $client = null): EntityManager
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface|null $eventDispatcher
     * @return \Bigcommerce\ORM\EntityManager
     */
    public function setEventDispatcher(?EventDispatcherInterface $eventDispatcher = null): EntityManager
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\PaymentAccessToken $token
     * @return \Bigcommerce\ORM\EntityManager
     */
    public function setPaymentAccessToken(PaymentAccessToken $token)
    {
        $this->client->setPaymentAccessToken($token->getId());

        return $this;
    }
}
