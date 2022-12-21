<?php

namespace Bigcommerce\ORM\Mapper;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations\Field;
use Bigcommerce\ORM\Annotations\Resource;
use Bigcommerce\ORM\Exceptions\MapperException;
use Bigcommerce\ORM\Meta\MetadataBuilder;
use Bigcommerce\ORM\Relation\ManyRelationInterface;
use Bigcommerce\ORM\Relation\OneRelationInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Throwable;

class EntityPatcher
{
    protected \Doctrine\Common\Annotations\AnnotationReader $reader;
    protected \Bigcommerce\ORM\Mapper\EntityReader $entityReader;
    protected \Bigcommerce\ORM\Meta\MetadataBuilder $metadataBuilder;

    /**
     * EntityPatcher constructor.
     * @param \Doctrine\Common\Annotations\AnnotationReader|null $reader
     * @param \Bigcommerce\ORM\Mapper\EntityReader|null $entityReader
     * @param \Bigcommerce\ORM\Meta\MetadataBuilder|null $metadataBuilder
     */
    public function __construct(
        ?AnnotationReader $reader = null,
        EntityReader $entityReader = null,
        MetadataBuilder $metadataBuilder = null
    ) {
        $this->reader = $reader ?: new AnnotationReader();
        $this->entityReader = $entityReader ?? new EntityReader($this->reader);
        $this->metadataBuilder = $metadataBuilder ?? new MetadataBuilder($this->reader);
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
        $object = $this->object($class);

        return $this->patch($object, $data, $pathParams, false);
    }

    /**
     * Patch object properties with data array
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param array|null $data
     * @param array|null $pathParams
     * @param bool $propertyOnly
     * @return \Bigcommerce\ORM\AbstractEntity
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function patch(
        AbstractEntity $entity,
        ?array $data = null,
        ?array $pathParams = null,
        bool $propertyOnly = false
    ) {
        if (is_array($pathParams)) {
            $data = array_merge($data, $pathParams);
        }

        $reflectionClass = (new Reflection())->reflect($entity);
        $properties = $reflectionClass->getProperties();
        foreach ($properties as $property) {
            $annotations = $this->reader->getPropertyAnnotations($property);
            foreach ($annotations as $annotation) {
                if ($annotation instanceof Field) {
                    if (isset($data[$annotation->name])) {
                        $this->entityReader->setPropertyValue($entity, $property, $data[$annotation->name]);
                    }
                }
            }
        }

        $this->entityReader->setPropertyValueByName($entity, 'isPatched', true);
        $resource = $this->getResource($entity);
        $metadata = $this->metadataBuilder->build($resource, $properties);
        $this->entityReader->setPropertyValueByName($entity, 'metadata', $metadata);

        if ($propertyOnly == true) {
            return $entity;
        }

        if (!empty($autoIncludes = $metadata->getIncludeFields())) {
            $this->patchAutoIncludes($entity, $autoIncludes, $data, $pathParams);
        }

        if (!empty($inResultFields = $metadata->getInResultFields())) {
            $this->patchAutoIncludes($entity, $inResultFields, $data, $pathParams);
        }

        return $entity;
    }

    /**
     * @param string $className
     * @param array|null $pathParams
     * @return \Bigcommerce\ORM\AbstractEntity
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function patchFromClass(string $className, ?array $pathParams = null)
    {
        $object = $this->object($className);

        return $this->patch($object, [], $pathParams, true);
    }

    /**
     * @param array|null $array
     * @param string|null $className
     * @param array|null $pathParams
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function patchArrayToCollection(?array $array = null, ?string $className = null, ?array $pathParams = null)
    {
        $collections = [];
        if (!empty($array)) {
            foreach ($array as $item) {
                $object = $this->object($className);
                $relationEntity = $this->patch($object, $item, $pathParams, false);
                $collections[] = $relationEntity;
            }
        }

        return $collections;
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param array|null $autoIncludes
     * @param array|null $items
     * @param array|null $pathParams
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function patchAutoIncludes(
        AbstractEntity $entity,
        ?array $autoIncludes = null,
        ?array $items = null,
        ?array $pathParams = null
    ) {
        foreach ($autoIncludes as $fieldName => $include) {
            $property = $include['property'];
            $annotation = $include['annotation'];
            if (isset($items[$annotation->name])) {
                if (!is_array($pathParams)) {
                    $pathParams = [$annotation->targetField => $entity->getId()];
                } else {
                    $pathParams = array_merge($pathParams, [$annotation->targetField => $entity->getId()]);
                }

                if ($annotation instanceof ManyRelationInterface) {
                    $propertyValue = $this->includesToCollection(
                        $annotation->targetClass,
                        $items[$annotation->name],
                        $pathParams
                    );
                    $this->entityReader->setPropertyValue($entity, $property, $propertyValue);
                }

                if ($annotation instanceof OneRelationInterface) {
                    $object = $this->object($annotation->targetClass);
                    $propertyValue = $this->patch($object, $items[$annotation->name], $pathParams, false);
                    $this->entityReader->setPropertyValue($entity, $property, $propertyValue);
                }
            }
        }
    }

    /**
     * @param string|null $className
     * @param array|null $items
     * @param array|null $pathParams
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function includesToCollection(?string $className = null, ?array $items = null, ?array $pathParams = null)
    {
        $collections = [];
        if (!empty($items)) {
            foreach ($items as $item) {
                $object = $this->object($className);
                $relationEntity = $this->patch($object, $item, $pathParams, false);
                $collections[] = $relationEntity;
            }
        }

        return $collections;
    }

    /**
     * Create Entity object from class name
     *
     * @param string $class class name
     * @return \Bigcommerce\ORM\AbstractEntity
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function object(string $class)
    {
        try {
            $object = new $class();
        } catch (Throwable $exception) {
            throw new MapperException(MapperException::ERROR_INVALID_CLASS_NAME . $class);
        }

        return $object;
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @return \Bigcommerce\ORM\Annotations\Resource|object
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getResource(AbstractEntity $entity)
    {
        $reflectionClass = (new Reflection())->reflect($entity);

        return $this->reader->getClassAnnotation($reflectionClass, Resource::class);
    }
}
