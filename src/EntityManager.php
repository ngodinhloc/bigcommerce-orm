<?php

declare(strict_types=1);

namespace Bigcommerce\ORM;

use Bigcommerce\ORM\Client\ClientInterface;
use Bigcommerce\ORM\Entities\PaymentAccessToken;
use Bigcommerce\ORM\Events\EntityManagerEvent;
use Bigcommerce\ORM\Exceptions\EntityException;
use Bigcommerce\ORM\Mapper\Autoloader;
use Bigcommerce\ORM\Mapper\Converter;
use Bigcommerce\ORM\Mapper\DataBuilder;
use Bigcommerce\ORM\Mapper\EntityMapper;
use Bigcommerce\ORM\Mapper\EntityTransformer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class EntityManager
 * @package Bigcommerce\ORM
 */
class EntityManager
{
    protected ?\Bigcommerce\ORM\Client\ClientInterface $client;
    protected ?\Bigcommerce\ORM\Mapper\EntityMapper $mapper;
    protected ?\Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher;

    /**
     * EntityManager constructor.
     *
     * @param \Bigcommerce\ORM\Client\ClientInterface $client
     * @param \Bigcommerce\ORM\Mapper\EntityMapper|null $mapper
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface|null $eventDispatcher
     */
    public function __construct(
        ClientInterface $client,
        ?EntityMapper $mapper = null,
        ?EventDispatcherInterface $eventDispatcher = null
    ) {
        $this->client = $client;
        $this->mapper = $mapper ?: new EntityMapper();
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
        $entity = $this->mapper->getEntityPatcher()->patchFromClass($className, $pathParams);
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
    public function findBy(
        string $className,
        ?array $pathParams = null,
        ?QueryBuilder $queryBuilder = null,
        $auto = false
    ) {
        $entity = $this->mapper->getEntityPatcher()->patchFromClass($className, $pathParams);
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
        $entity = $this->mapper->getEntityPatcher()->patchFromClass($className, $pathParams);
        $resourcePath = $this->mapper->getResourcePath($entity, 'find');
        $resourceType = $entity->getMetadata()->getResource()->type;
        $autoIncludes = $entity->getMetadata()->getIncludeFields();

        $query = (new QueryBuilder())->include(array_keys($autoIncludes))->getQueryString();
        $result = $this->client->find($resourcePath . "/{$id}?" . $query, $resourceType);
        if (empty($result)) {
            return false;
        }

        $entity = $this->mapper->getEntityPatcher()->patch($entity, $result, $pathParams, false);
        if ($auto == false) {
            return $entity;
        }

        if (empty($entity->getMetadata()->getAutoLoadFields())) {
            /** there is not fields that required autoload */
            return $entity;
        }

        return (new Autoloader($this))->autoLoad($entity, $result, $pathParams);
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
        $this->mapper->getEntityValidator()->checkEntity($entity);
        if ($entity->isPatched() !== true) {
            $entity = $this->mapper->getEntityPatcher()->patch($entity, [], null, true);
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
        $this->mapper->getEntityValidator()->checkEntity($entity);

        if ($entity->isPatched() !== true) {
            $entity = $this->mapper->getEntityPatcher()->patch($entity, [], null, true);
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
        $this->mapper->getEntityValidator()->checkEntity($entity);
        $this->mapper->getEntityValidator()->checkId($entity->getId());

        if (empty($data)) {
            return true;
        }

        if ($entity->isPatched() !== true) {
            $entity = $this->mapper->getEntityPatcher()->patch($entity, [], null, true);
        }

        if (!$this->mapper->getEntityValidator()->checkFieldValues($data)) {
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
        if (!empty($result)) {
            $this->dispatchEvent(EntityManagerEvent::ENTITY_DELETED, $entity);

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

        foreach ($entities as $en) {
            $this->checkBeforeCreating($en);
        }

        $className = get_class(current($entities));
        $entity = $this->mapper->getEntityPatcher()->patchFromClass($className, $pathParams);
        $batchCreateData = (new DataBuilder($this->mapper))->buildBatchCreateData($className, $entities);

        $result = $this->client->create(
            $this->mapper->getResourcePath($entity),
            $entity->getMetadata()->getResource()->type,
            $batchCreateData,
            null,
            true
        );
        if (!empty($result)) {
            return $this->getMapper()->getEntityTransformer()->batchCreateResultToEntities(
                $className,
                $result,
                $pathParams
            );
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
        foreach ($entities as $en) {
            $this->checkBeforeUpdating($en);
        }

        $className = get_class(current($entities));
        $entity = $this->mapper->getEntityPatcher()->patchFromClass($className, $pathParams);
        $batchUpdateData = (new DataBuilder($this->mapper))->buildBatchUpdateData($className, $entities);

        $result = $this->client->update(
            $this->mapper->getResourcePath($entity),
            $entity->getMetadata()->getResource()->type,
            $batchUpdateData,
            null,
            true
        );
        if (!empty($result)) {
            return $this->mapper->getEntityTransformer()->batchUpdateResultToEntities($entities, $result, $pathParams);
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
    public function batchDelete(
        string $className,
        ?array $pathParams = null,
        ?array $values = null,
        ?string $field = 'id'
    ) {
        if (empty($values)) {
            return false;
        }

        if (empty($field)) {
            $field = 'id';
        }

        $entity = $this->mapper->getEntityPatcher()->patchFromClass($className, $pathParams);
        $resourcePath = $this->mapper->getResourcePath($entity, 'delete');
        $resourceType = $entity->getMetadata()->getResource()->type;
        $query = (new QueryBuilder())->whereIn($field, array_values($values))->getQueryString();

        return $this->client->delete($resourcePath . "?" . $query, $resourceType);
    }

    /**
     * Create an entity from data
     *
     * @param string $class
     * @param array|null $data
     * @param array|null $pathParams
     * @return \Bigcommerce\ORM\AbstractEntity
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function new(string $class, ?array $data = null, ?array $pathParams = null)
    {
        return $this->mapper->getEntityPatcher()->new($class, $data, $pathParams);
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
        return $this->mapper->getEntityPatcher()->patch($entity, $data, $pathParams, false);
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param int $key
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @see \Bigcommerce\ORM\Mapper\EntityTransformer::KEY_BY_FIELD_NAME
     * @see \Bigcommerce\ORM\Mapper\EntityTransformer::KEY_BY_PROPERTY_NAME
     */
    public function toArray(AbstractEntity $entity, int $key = EntityTransformer::KEY_BY_FIELD_NAME)
    {
        return $this->mapper->getEntityTransformer()->entityToArray($entity, $key);
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function checkBeforeCreating(AbstractEntity $entity)
    {
        if ($entity->isPaymentAccessTokenRequired()) {
            if (empty($paymentAccessToken = $entity->getPaymentAccessToken())) {
                throw new EntityException(EntityException::ERROR_PAYMENT_ACCESS_TOKEN_REQUIRED);
            }
            $this->setPaymentAccessToken($paymentAccessToken);
        }

        $checkRequiredProperties = $this->mapper->checkRequiredFields($entity);
        if ($checkRequiredProperties !== true) {
            throw new EntityException(
                EntityException::ERROR_REQUIRED_PROPERTIES . implode(", ", $checkRequiredProperties)
            );
        }

        $checkRequiredValidations = $this->mapper->checkRequiredValidations($entity);
        if ($checkRequiredValidations !== true) {
            throw new EntityException(
                EntityException::ERROR_REQUIRED_VALIDATIONS . implode(", ", $checkRequiredValidations)
            );
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
            throw new EntityException(
                EntityException::ERROR_REQUIRED_VALIDATIONS . implode(", ", $checkRequiredValidations)
            );
        }
    }

    /**
     * @param array|null $array
     * @param string|null $className
     * @param array|null $pathParams
     * @param bool $auto
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function arrayToCollection(
        ?array $array = null,
        ?string $className = null,
        ?array $pathParams = null,
        bool $auto = false
    ) {
        return (new Converter($this))->arrayToCollection($array, $className, $pathParams, $auto);
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
        if (!$this->mapper->getEntityValidator()->checkFieldValues($data)) {
            throw new EntityException(EntityException::ERROR_EMPTY_PROPERTY_VALUES);
        }

        $resourcePath = $this->mapper->getResourcePath($entity, 'create');
        $resourceType = $entity->getMetadata()->getResource()->type;
        $files = $this->mapper->getEntityReader()->getUploadFiles($entity);

        $result = $this->client->create($resourcePath, $resourceType, $data, $files);
        if (!empty($result)) {
            $this->mapper->getEntityPatcher()->patch($entity, $result, null, false);
            $this->mapper->getEntityReader()->setPropertyValueByName($entity, 'isNew', true);
            $this->dispatchEvent(EntityManagerEvent::ENTITY_CREATED, $entity);

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
        if (!$this->mapper->getEntityValidator()->checkFieldValues($data)) {
            return true;
        }

        $resourcePath = $this->mapper->getResourcePath($entity, 'update');
        $resourceType = $entity->getMetadata()->getResource()->type;
        $files = $this->mapper->getEntityReader()->getUploadFiles($entity);

        $result = $this->client->update($resourcePath . "/{$entity->getId()}", $resourceType, $data, $files);
        if (!empty($result)) {
            if (isset($result['id']) && $result['id'] == $entity->getId()) {
                $this->mapper->getEntityPatcher()->patch($entity, $result, null, false);
            }
            $this->mapper->getEntityReader()->setPropertyValueByName($entity, 'isNew', false);
            $this->dispatchEvent(EntityManagerEvent::ENTITY_UPDATED, $entity);

            return true;
        }

        return false;
    }

    /**
     * @param string $eventName
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     */
    private function dispatchEvent(string $eventName, AbstractEntity $entity)
    {
        if ($this->hasEventDispatcher()) {
            $this->eventDispatcher->dispatch($eventName, new EntityManagerEvent($eventName, $entity));
        }
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
     * @return \Bigcommerce\ORM\Mapper\EntityMapper
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * @param \Bigcommerce\ORM\Mapper\EntityMapper|null $mapper
     * @return \Bigcommerce\ORM\EntityManager
     */
    public function setMapper(?EntityMapper $mapper = null)
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
