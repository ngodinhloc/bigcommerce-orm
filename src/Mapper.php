<?php

declare(strict_types=1);

namespace Bigcommerce\ORM;

use Bigcommerce\ORM\Annotations\Field;
use Bigcommerce\ORM\Annotations\Resource;
use Bigcommerce\ORM\Exceptions\EntityException;
use Bigcommerce\ORM\Exceptions\MapperException;
use Bigcommerce\ORM\Mapper\EntityReader;
use Bigcommerce\ORM\Mapper\EntityTransformer;
use Bigcommerce\ORM\Mapper\Reflection;
use Bigcommerce\ORM\Relation\ManyRelationInterface;
use Bigcommerce\ORM\Relation\OneRelationInterface;
use Bigcommerce\ORM\Relation\RelationInterface;
use Bigcommerce\ORM\Validation\ValidationInterface;
use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class Mapper
 * @package Bigcommerce\ORM
 */
class Mapper
{
    const KEY_BY_FIELD_NAME = 1;
    const KEY_BY_PROPERTY_NAME = 2;

    /** @var \Doctrine\Common\Annotations\AnnotationReader */
    protected $reader;

    /** @var \Bigcommerce\ORM\Mapper\EntityReader */
    protected $entityReader;

    /** @var \Bigcommerce\ORM\Mapper\EntityTransformer */
    protected $entityTransformer;

    /**
     * Mapper constructor.
     *
     * @param \Doctrine\Common\Annotations\AnnotationReader|null $reader reader
     */
    public function __construct(?AnnotationReader $reader = null)
    {
        $this->reader = $reader ?: new AnnotationReader();
        $this->entityReader = new EntityReader($this->reader);
        $this->entityTransformer = new EntityTransformer($this->reader);
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
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param string|null $action
     * @return string
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function getResourcePath(AbstractEntity $entity, ?string $action = null)
    {
        if ($entity->isPatched() !== true) {
            $entity = $this->patch($entity, [], null, true);
        }

        $resource = $entity->getMetadata()->getResource();
        if (empty($resource->path)) {
            throw new EntityException(EntityException::ERROR_EMPTY_RESOURCE_PATH . $resource->name);
        }

        if (!empty($action)) {
            $this->checkResourceAction($resource, $action);
        }

        $path = $resource->path;
        $paramFields = $entity->getMetadata()->getParamFields();
        if (empty($paramFields)) {
            return $path;
        }

        foreach ($paramFields as $fieldName => $property) {
            $value = $this->entityReader->getPropertyValue($entity, $property);
            if (empty($value)) {
                throw new MapperException(sprintf(MapperException::ERROR_MISSING_PATH_PARAMS, $path, $fieldName));
            }
            $path = str_replace("{{$fieldName}}", "{$value}", $path);
        }

        if (preg_match('/{.*}/', $path)) {
            throw new MapperException(sprintf(MapperException::ERROR_PATH_PARAMS_REQUIRED, $path));
        }

        return $path;
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
        $metadata = $this->getMetadata($resource, $properties);
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
     * Check for entity required fields
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @return bool|array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function checkRequiredFields(AbstractEntity $entity)
    {
        if ($entity->isPatched() !== true) {
            $entity = $this->patch($entity, [], null, true);
        }

        if (empty($requiredFields = $entity->getMetadata()->getRequiredFields())) {
            return true;
        }

        $missingFields = [];
        /* @var \ReflectionProperty $property */
        foreach ($requiredFields as $fieldName => $property) {
            if ($this->entityReader->getPropertyValue($entity, $property) === null) {
                $missingFields[$fieldName] = $property->name;
            }
        }

        if (empty($missingFields)) {
            return true;
        }

        return $missingFields;
    }

    /**
     * Get writable data
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param array|null $data
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getWritableFieldValues(AbstractEntity $entity, ?array $data = null)
    {
        if ($entity->isPatched() !== true) {
            $entity = $this->patch($entity, [], null, true);
        }

        if (empty($data)) {
            $data = $this->entityTransformer->toArray($entity);
        }

        if (empty($readonlyFields = $entity->getMetadata()->getReadonlyFields())) {
            return $data;
        }

        return array_diff_key($data, $readonlyFields);
    }

    /**
     * @param array|null $data
     * @return bool
     */
    public function checkFieldValues(?array $data = null)
    {
        if (empty($data)) {
            return false;
        }

        foreach ($data as $field => $value) {
            if ($value !== null) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for entity validations
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @return bool|array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function checkRequiredValidations(AbstractEntity $entity)
    {
        if ($entity->isPatched() !== true) {
            $entity = $this->patch($entity, [], null, true);
        }

        if (empty($validationProperties = $entity->getMetadata()->getValidationProperties())) {
            return true;
        }

        $validationRules = [];
        /* @var \ReflectionProperty $property */
        foreach ($validationProperties as $propertyName => $rule) {
            $property = $rule['property'];
            $annotation = $rule['annotation'];
            if ($annotation instanceof ValidationInterface) {
                $validator = $annotation->getValidator($this);
                $check = $validator->validate($entity, $property, $annotation);
                if (!$check) {
                    $validationRules[$propertyName] = $property->name . ": " . get_class($annotation);
                }
            }
        }

        if (empty($validationRules)) {
            return true;
        }

        return $validationRules;
    }

    /**
     * @param array|null $array
     * @param string|null $className
     * @param array|null $pathParams
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function arrayToCollection(?array $array = null, ?string $className = null, ?array $pathParams = null)
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

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function checkEntity(AbstractEntity $entity)
    {
        if (!$entity instanceof AbstractEntity) {
            throw new EntityException(EntityException::ERROR_NOT_ENTITY_INSTANCE);
        }
    }

    /**
     * @param string|null $className
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function checkClass(?string $className)
    {
        if (empty($className)) {
            throw new EntityException(EntityException::ERROR_EMPTY_CLASS_NAME);
        }
    }

    /**
     * @param int|string|null $id
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function checkId($id = null)
    {
        if (empty($id)) {
            throw new EntityException(EntityException::ERROR_ID_IS_NOT_PROVIDED);
        }
    }

    /**
     * @param \Bigcommerce\ORM\Annotations\Resource|null $resource
     * @param string|null $action
     * @return bool
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    private function checkResourceAction(?Resource $resource = null, ?string $action = null)
    {
        switch ($action) {
            case 'find':
                if ($resource->findable !== true) {
                    throw new EntityException(EntityException::ERROR_NOT_FINDABLE_RESOURCE . $resource->name);
                }
                break;
            case 'create':
                if ($resource->creatable !== true) {
                    throw new EntityException(EntityException::ERROR_NOT_CREATABLE_RESOURCE . $resource->name);
                }
                break;
            case 'update':
                if ($resource->updatable !== true) {
                    throw new EntityException(EntityException::ERROR_NOT_UPDATABLE_RESOURCE . $resource->name);
                }
                break;
            case 'delete':
                if ($resource->deletable !== true) {
                    throw new EntityException(EntityException::ERROR_NOT_DELETABLE_RESOURCE . $resource->name);
                }
                break;
        }

        return true;
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
     * @return \Bigcommerce\ORM\Mapper\EntityReader
     */
    public function getEntityReader(): \Bigcommerce\ORM\Mapper\EntityReader
    {
        return $this->entityReader;
    }

    /**
     * @param \Bigcommerce\ORM\Mapper\EntityReader $entityReader
     * @return \Bigcommerce\ORM\Mapper
     */
    public function setEntityReader(\Bigcommerce\ORM\Mapper\EntityReader $entityReader): Mapper
    {
        $this->entityReader = $entityReader;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Mapper\EntityTransformer
     */
    public function getEntityTransformer(): \Bigcommerce\ORM\Mapper\EntityTransformer
    {
        return $this->entityTransformer;
    }

    /**
     * @param \Bigcommerce\ORM\Mapper\EntityTransformer $entityTransformer
     * @return \Bigcommerce\ORM\Mapper
     */
    public function setEntityTransformer(\Bigcommerce\ORM\Mapper\EntityTransformer $entityTransformer): Mapper
    {
        $this->entityTransformer = $entityTransformer;

        return $this;
    }
}
