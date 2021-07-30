<?php

namespace Bigcommerce\ORM\Mapper;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations\Field;
use Bigcommerce\ORM\Annotations\Resource;
use Bigcommerce\ORM\Exceptions\MapperException;
use Bigcommerce\ORM\Metadata;
use Bigcommerce\ORM\Relation\ManyRelationInterface;
use Bigcommerce\ORM\Relation\OneRelationInterface;
use Bigcommerce\ORM\Relation\RelationInterface;
use Bigcommerce\ORM\Validation\ValidationInterface;
use Doctrine\Common\Annotations\AnnotationReader;

class Patcher
{
    /** @var \Doctrine\Common\Annotations\AnnotationReader */
    protected $reader;

    /**
     * Patcher constructor.
     * @param \Doctrine\Common\Annotations\AnnotationReader|null $reader
     */
    public function __construct(?AnnotationReader $reader = null)
    {
        $this->reader = $reader ?: new AnnotationReader();
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
                        $this->setPropertyValue($entity, $property, $data[$annotation->name]);
                    }
                }
            }
        }

        $this->setPropertyValueByName($entity, 'isPatched', true);
        $resource = $this->getResource($entity);
        $metadata = $this->getMetadata($resource, $properties);
        $this->setPropertyValueByName($entity, 'metadata', $metadata);

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
     * Set property value
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param \ReflectionProperty $property
     * @param mixed|null $value
     * @return void
     */
    public function setPropertyValue(AbstractEntity $entity, \ReflectionProperty $property, $value = null)
    {
        $property->setAccessible(true);
        $property->setValue($entity, $value);
    }

    /**
     * Set property value by name
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param string $propertyName
     * @param mixed $value
     * @return void
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function setPropertyValueByName(AbstractEntity $entity, string $propertyName, $value)
    {
        $property = $this->getProperty($entity, $propertyName);
        $this->setPropertyValue($entity, $property, $value);
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

    /**
     * @param \Bigcommerce\ORM\Annotations\Resource|null $resource
     * @param \ReflectionProperty[] $properties
     * @return \Bigcommerce\ORM\Metadata
     */
    private function getMetadata(?Resource $resource = null, ?array $properties = null)
    {
        $relationFields = [];
        $autoLoadFields = [];
        $includeFields = [];
        $inResultFields = [];
        $requiredFields = [];
        $readonlyFields = [];
        $customisedFields = [];
        $validationFields = [];
        $uploadFiles = [];
        $paramFields = [];

        foreach ($properties as $property) {
            $annotations = $this->reader->getPropertyAnnotations($property);
            foreach ($annotations as $annotation) {
                if ($annotation instanceof Field) {
                    if ($annotation->required == true) {
                        $requiredFields[$annotation->name] = $property;
                    }
                    if ($annotation->readonly == true) {
                        $readonlyFields[$annotation->name] = $property;
                    }
                    if ($annotation->customised == true) {
                        $customisedFields[$annotation->name] = $property;
                    }
                    if ($annotation->upload == true) {
                        $uploadFiles[$annotation->name] = $property;
                    }
                    if ($annotation->pathParam == true) {
                        $paramFields[$annotation->name] = $property;
                    }
                }

                if ($annotation instanceof RelationInterface) {
                    $relationFields[$annotation->name] = ['property' => $property, 'annotation' => $annotation];
                    if ($annotation->auto === true && $annotation->from === 'include') {
                        $includeFields[$annotation->name] = ['property' => $property, 'annotation' => $annotation];
                    }

                    if ($annotation->auto === true && $annotation->from === 'api') {
                        $autoLoadFields[$annotation->name] = ['property' => $property, 'annotation' => $annotation];
                    }

                    if ($annotation->from === 'result') {
                        $inResultFields[$annotation->name] = ['property' => $property, 'annotation' => $annotation];
                    }
                }

                if ($annotation instanceof ValidationInterface) {
                    if ($annotation->validate === true) {
                        $validationFields[$property->name] = ['property' => $property, 'annotation' => $annotation];
                    }
                }
            }
        }

        $metadata = new Metadata();
        $metadata
            ->setResource($resource)
            ->setReadonlyFields($readonlyFields)
            ->setRequiredFields($requiredFields)
            ->setCustomisedFields($customisedFields)
            ->setRelationFields($relationFields)
            ->setIncludeFields($includeFields)
            ->setAutoLoadFields($autoLoadFields)
            ->setInResultFields($inResultFields)
            ->setValidationProperties($validationFields)
            ->setUploadFields($uploadFiles)
            ->setParamFields($paramFields);

        return $metadata;
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
                    $this->setPropertyValue($entity, $property, $propertyValue);
                }

                if ($annotation instanceof OneRelationInterface) {
                    $object = $this->object($annotation->targetClass);
                    $propertyValue = $this->patch($object, $items[$annotation->name], $pathParams, false);
                    $this->setPropertyValue($entity, $property, $propertyValue);
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
        } catch (\Throwable $exception) {
            throw new MapperException(MapperException::ERROR_INVALID_CLASS_NAME . $class);
        }

        return $object;
    }
}
