<?php
declare(strict_types=1);

namespace Bigcommerce\ORM;

use Bigcommerce\ORM\Client\ClientInterface;
use Bigcommerce\ORM\Events\EntityManagerEvent;
use Bigcommerce\ORM\Exceptions\EntityException;
use Bigcommerce\ORM\Relation\RelationInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

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

    /** @var \Symfony\Contracts\EventDispatcher\EventDispatcherInterface */
    protected $eventDispatcher;

    /**
     * EntityManager constructor.
     *
     * @param \Bigcommerce\ORM\Client\ClientInterface|null $client
     * @param \Bigcommerce\ORM\Mapper|null $mapper mapper
     * @param \Symfony\Contracts\EventDispatcher\EventDispatcherInterface|null $eventDispatcher
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct(
        ClientInterface $client = null,
        Mapper $mapper = null,
        EventDispatcherInterface $eventDispatcher = null)
    {
        $this->client = $client;
        $this->mapper = $mapper ?: new Mapper();
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Count the total number of object
     *
     * @param string|null $className
     * @param array|null $parentIds
     * @return int|false
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function count(string $className = null, array $parentIds = null)
    {
        $this->mapper->checkClass($className);

        $entity = $this->mapper->object($className);
        $entity = $this->mapper->patch($entity, $parentIds, true);
        $path = $this->mapper->getResourcePath($entity);

        return $this->client->count($path);
    }

    /**
     * Find all object of a class name
     *
     * @param string|null $className class
     * @param array|null $parentIds
     * @param array|null $order order
     * @param bool $auto lazy loading
     * @return array|bool
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function findAll(string $className = null, array $parentIds = null, array $order = null, bool $auto = false)
    {
        $this->mapper->checkClass($className);

        $object = $this->mapper->object($className);
        $entity = $this->mapper->patch($object, $parentIds, true);
        $path = $this->mapper->getResourcePath($entity);
        $autoIncludes = $entity->getMetadata()->getIncludeFields();

        $queryBuilder = new QueryBuilder();
        if (!empty($order)) {
            $queryBuilder->order($order);
        }
        $queryString = $queryBuilder->include(array_keys($autoIncludes))->getQueryString();
        $result = $this->client->findAll($path . "?" . $queryString);

        return $this->arrayToCollection($result, $className, $parentIds, $auto);
    }

    /**
     * Query objects by conditions
     *
     * @param string|null $className
     * @param array|null $parentIds
     * @param \Bigcommerce\ORM\QueryBuilder|null $queryBuilder
     * @param bool $auto
     * @return array|false
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function findBy(string $className = null, array $parentIds = null, QueryBuilder $queryBuilder = null, $auto = false)
    {
        $this->mapper->checkClass($className);

        $object = $this->mapper->object($className);
        $entity = $this->mapper->patch($object, $parentIds, true);
        $path = $this->mapper->getResourcePath($entity);
        $autoIncludes = $entity->getMetadata()->getIncludeFields();
        $queryString = $queryBuilder->include(array_keys($autoIncludes))->getQueryString();
        $result = $this->client->findBy($path . "?" . $queryString);

        return $this->arrayToCollection($result, $className, $parentIds, $auto);
    }

    /**
     * @param string|null $className
     * @param int|null $id
     * @param array|null $parentIds
     * @param bool $auto
     * @return \Bigcommerce\ORM\Entity|false
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws Exceptions\MapperException
     */
    public function find(string $className = null, int $id = null, array $parentIds = null, bool $auto = false)
    {
        $this->mapper->checkClass($className);
        $this->mapper->checkId($id);

        $object = $this->mapper->object($className);
        $entity = $this->mapper->patch($object, $parentIds, true);
        $path = $this->mapper->getResourcePath($entity);
        $autoIncludes = $entity->getMetadata()->getIncludeFields();

        $queryBuilder = new QueryBuilder();
        $query = $queryBuilder->include(array_keys($autoIncludes))->getQueryString();
        $result = $this->client->find($path . "/{$id}?" . $query);

        if (empty($result)) {
            return false;
        }

        $entity = $this->mapper->patch($entity, $result);
        if ($auto == false) {
            return $entity;
        }
        // No auto loading
        if (empty($entity->getMetadata()->getAutoLoadFields())) {
            return $entity;
        }

        // auto loading
        return $this->autoLoad($entity, $result, $parentIds);
    }

    /**
     * Save entity
     * If id is provided: update entity
     * No id provided: create entity
     *
     * @param \Bigcommerce\ORM\Entity $entity entity
     * @return bool
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     */
    public function save(Entity $entity)
    {
        $this->mapper->checkEntity($entity);

        if ($entity->isPatched() !== true) {
            $entity = $this->mapper->patch($entity, [], true);
        }

        $checkRequiredProperties = $this->mapper->checkRequiredFields($entity);
        if ($checkRequiredProperties !== true) {
            throw new EntityException(EntityException::MSG_REQUIRED_PROPERTIES . implode(", ", $checkRequiredProperties));
        }

        $checkRequiredValidations = $this->mapper->checkRequiredValidations($entity);
        if ($checkRequiredValidations !== true) {
            throw new EntityException(EntityException::MSG_REQUIRED_VALIDATIONS . implode(", ", $checkRequiredValidations));
        }

        $path = $this->mapper->getResourcePath($entity);
        $data = $this->mapper->getNoneReadonlyData($entity);

        // update entity
        if (!empty($id = $entity->getId())) {
            return $this->updateEntity($entity, $data, $path);
        }

        // create entity
        return $this->createEntity($entity, $data, $path);
    }

    /**
     * Update entity : allow to update entity with array of data
     *
     * @param \Bigcommerce\ORM\Entity|null $entity entity
     * @param array $data [fieldName => value]
     * @return bool
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function update(Entity $entity = null, array $data = [])
    {
        $this->mapper->checkEntity($entity);
        $this->mapper->checkId($entity->getId());

        if (empty($data)) {
            return true;
        }

        if ($entity->isPatched() !== true) {
            $entity = $this->mapper->patch($entity, [], true);
        }

        $checkRequiredValidations = $this->mapper->checkRequiredValidations($entity);
        if ($checkRequiredValidations !== true) {
            throw new EntityException(EntityException::MSG_REQUIRED_VALIDATIONS . implode(", ", $checkRequiredValidations));
        }

        if (!$this->mapper->checkNoneReadonlyData($data)) {
            return true;
        }

        $data = $this->mapper->getNoneReadonlyData($entity, $data);
        $path = $this->mapper->getResourcePath($entity);

        return $this->updateEntity($entity, $data, $path);
    }

    /**
     * Create an entity from data
     * @param string|null $class
     * @param array|null $data
     * @return \Bigcommerce\ORM\Entity
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function new(string $class = null, array $data = null)
    {
        $this->mapper->checkClass($class);
        $object = $this->mapper->object($class);

        return $this->mapper->patch($object, $data, true);
    }

    /**
     * Patch entity with data array
     *
     * @param \Bigcommerce\ORM\Entity|null $entity entity
     * @param array|null $array data
     * @return \Bigcommerce\ORM\Entity
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function patch(Entity $entity = null, array $array = [])
    {
        return $this->mapper->patch($entity, $array, true);
    }

    /**
     * @param \Bigcommerce\ORM\Entity $entity
     * @param int $key
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @see \Bigcommerce\ORM\Mapper::KEY_BY_FIELD_NAME
     * @see \Bigcommerce\ORM\Mapper::KEY_BY_PROPERTY_NAME
     */
    public function toArray(Entity $entity, int $key = Mapper::KEY_BY_FIELD_NAME)
    {
        return $this->mapper->toArray($entity, $key);
    }

    /**
     * @param array|null $array
     * @param string|null $className
     * @param array|null $parentIds
     * @param bool $auto
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function arrayToCollection(array $array = null, string $className = null, array $parentIds = null, bool $auto = false)
    {
        $collections = [];
        if (!empty($array)) {
            foreach ($array as $item) {
                $object = $this->mapper->object($className);
                if (!empty($parentIds)) {
                    $item = array_merge($item, $parentIds);
                }
                $relationEntity = $this->mapper->patch($object, $item);
                if ($auto == false) {
                    $collections[] = $relationEntity;
                } else {
                    if (empty($relationEntity->getMetadata()->getAutoLoadFields())) {
                        $collections[] = $relationEntity;
                    } else {
                        $collections[] = $this->autoLoad($relationEntity, $item, $parentIds);
                    }
                }
            }
        }

        return $collections;
    }

    /**
     * Load object in relations
     *
     * @param \Bigcommerce\ORM\Entity|null $entity entity
     * @param array|null $data
     * @param array|null $parentIds
     * @return \Bigcommerce\ORM\Entity
     */
    private function autoLoad(Entity $entity = null, array $data = null, array $parentIds = null)
    {
        if (empty($entity) || empty($entity->getMetadata()->getAutoLoadFields())) {
            return $entity;
        }
        foreach ($entity->getMetadata()->getAutoLoadFields() as $fieldName => $load) {
            $property = $load['property'];
            $annotation = $load['annotation'];
            if ($annotation instanceof RelationInterface) {
                $handler = $annotation->getHandler($this);
                $handler->handle($entity, $property, $annotation, $data, $parentIds);
            }
        }

        return $entity;
    }

    /**
     * @param \Bigcommerce\ORM\Entity $entity
     * @param array $data
     * @param string $path
     * @return bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function createEntity(Entity $entity, array $data, string $path)
    {
        if (!$this->mapper->checkNoneReadonlyData($data)) {
            throw new EntityException(EntityException::MSG_EMPTY_NONE_READONLY_DATA);
        }

        $files = [];
        if (!empty($uploadFields = $entity->getMetadata()->getUploadFields())) {
            foreach ($uploadFields as $fieldName => $property) {
                $location = $this->mapper->getPropertyValue($entity, $property);
                if (!empty($location)) {
                    if (!file_exists($location)) {
                        throw new EntityException(EntityException::MSG_INVALID_UPLOAD_FILE . $location);
                    }
                    $files[$fieldName] = $location;
                }
            }
        }

        $result = $this->client->create($path, $data, $files);
        if (!empty($result)) {
            $this->mapper->patch($entity, $result, true);
            $this->mapper->setPropertyValueByName($entity, 'isNew', true);
            if ($this->hasEventDispatcher()) {
                $this->eventDispatcher->dispatch(
                    new EntityManagerEvent(EntityManagerEvent::ENTITY_CREATED, $entity),
                    EntityManagerEvent::ENTITY_CREATED
                );
            }

            return true;
        }

        return false;
    }

    /**
     * @param \Bigcommerce\ORM\Entity $entity
     * @param array $data
     * @param string $path
     * @return bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function updateEntity(Entity $entity, array $data, string $path)
    {
        if (!$this->mapper->checkNoneReadonlyData($data)) {
            return true;
        }

        $path = $path . "/{$entity->getId()}";
        $result = $this->client->update($path, $data);
        if (!empty($result)) {
            $this->mapper->patch($entity, $result, true);
            $this->mapper->setPropertyValueByName($entity, 'isNew', false);
            if ($this->hasEventDispatcher()) {
                $this->eventDispatcher->dispatch(
                    new EntityManagerEvent(EntityManagerEvent::ENTITY_UPDATED, $entity),
                    EntityManagerEvent::ENTITY_UPDATED
                );
            }

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function hasEventDispatcher()
    {
        return ($this->eventDispatcher instanceof EventDispatcherInterface);
    }

    /**
     * @param string $class class
     * @return \Bigcommerce\ORM\Repository
     * @throws \Exception
     */
    public function getRepository(string $class = null)
    {
        $repository = new Repository($this);
        $repository->setClassName($class);

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
     * @param \Bigcommerce\ORM\Mapper $mapper mapper
     * @return \Bigcommerce\ORM\EntityManager
     */
    public function setMapper(Mapper $mapper = null)
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
     * @param \Bigcommerce\ORM\Client\ClientInterface $client
     * @return \Bigcommerce\ORM\EntityManager
     */
    public function setClient(ClientInterface $client): EntityManager
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return \Symfony\Contracts\EventDispatcher\EventDispatcherInterface
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @param \Symfony\Contracts\EventDispatcher\EventDispatcherInterface $eventDispatcher
     * @return \Bigcommerce\ORM\EntityManager
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): EntityManager
    {
        $this->eventDispatcher = $eventDispatcher;
        return $this;
    }
}
