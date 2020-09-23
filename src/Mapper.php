<?php
declare(strict_types=1);

namespace Bigcommerce\ORM;

use Bigcommerce\ORM\Annotations\Field;
use Bigcommerce\ORM\Annotations\Resource;
use Bigcommerce\ORM\Exceptions\EntityException;
use Bigcommerce\ORM\Exceptions\MapperException;
use Bigcommerce\ORM\Relation\ManyRelationInterface;
use Bigcommerce\ORM\Relation\OneRelationInterface;
use Bigcommerce\ORM\Relation\RelationInterface;
use Bigcommerce\ORM\Validation\ValidationInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use ReflectionClass;

/**
 * Class Mapper
 * @package Bigcommerce\ORM
 */
class Mapper
{

    /** @var \Doctrine\Common\Annotations\AnnotationReader */
    protected $reader;

    const KEY_BY_FIELD_NAME = 1;
    const KEY_BY_PROPERTY_NAME = 2;

    /**
     * Mapper constructor.
     *
     * @param \Doctrine\Common\Annotations\AnnotationReader|null $reader reader
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct(?AnnotationReader $reader = null)
    {
        $this->reader = $reader ?: new AnnotationReader();
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity|null $entity
     * @return \Bigcommerce\ORM\Annotations\Resource|object
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getResource(?AbstractEntity $entity = null)
    {
        $reflectionClass = $this->reflect($entity);

        return $this->reader->getClassAnnotation($reflectionClass, Resource::class);
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity|null $entity
     * @return string
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getResourcePath(?AbstractEntity $entity = null)
    {
        if ($entity->isPatched() !== true) {
            $entity = $this->patch($entity, [], null, true);
        }

        $resource = $entity->getMetadata()->getResource();
        $path = $resource->path;
        $paramFields = $entity->getMetadata()->getParamFields();
        if (empty($paramFields)) {
            return $path;
        }

        foreach ($paramFields as $fieldName => $property) {
            $value = $this->getPropertyValue($entity, $property);
            if (empty($value)) {
                throw new MapperException(sprintf(MapperException::ERROR_MISSING_PATH_PARAMS, $path, $fieldName));
            }
            $path = str_replace("{{$fieldName}}", $value, $path);
        }

        if (preg_match('/{.*}/', $path)) {
            throw new MapperException(sprintf(MapperException::ERROR_PATH_PARAMS_REQUIRED, $path));
        }

        return $path;
    }

    /**
     * Patch object properties with data array
     *
     * @param \Bigcommerce\ORM\AbstractEntity|null $entity
     * @param array|null $data
     * @param array|null $pathParams
     * @param bool $propertyOnly
     * @return \Bigcommerce\ORM\AbstractEntity
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function patch(?AbstractEntity $entity = null, ?array $data = null, ?array $pathParams = null, bool $propertyOnly = false)
    {
        if (is_array($pathParams)) {
            $data = array_merge($data, $pathParams);
        }

        $reflectionClass = $this->reflect($entity);
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
     * Check for entity required fields
     *
     * @param \Bigcommerce\ORM\AbstractEntity|null $entity
     * @return bool|array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function checkRequiredFields(?AbstractEntity $entity = null)
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
            if ($this->getPropertyValue($entity, $property) === null) {
                $missingFields[$fieldName] = $property->name;
            }
        }

        if (empty($missingFields)) {
            return true;
        }

        return $missingFields;
    }

    /**
     * Get none readonly data
     *
     * @param \Bigcommerce\ORM\AbstractEntity|null $entity
     * @param array|null $data
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getWritableFieldValues(?AbstractEntity $entity = null, ?array $data = null)
    {
        if ($entity->isPatched() !== true) {
            $entity = $this->patch($entity, [], null, true);
        }

        if (empty($data)) {
            $data = $this->toArray($entity);
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
    public function checkPropertyValues(?array $data = null)
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
     * @param \Bigcommerce\ORM\AbstractEntity|null $entity
     * @return bool|array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function checkRequiredValidations(?AbstractEntity $entity = null)
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
     * Get array of entity
     *
     * @param \Bigcommerce\ORM\AbstractEntity|null $entity
     * @param int|null $key
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @see \Bigcommerce\ORM\Mapper::KEY_BY_FIELD_NAME
     * @see \Bigcommerce\ORM\Mapper::KEY_BY_PROPERTY_NAME
     */
    public function toArray(?AbstractEntity $entity = null, ?int $key = self::KEY_BY_FIELD_NAME)
    {
        $reflectionClass = $this->reflect($entity);
        $properties = $reflectionClass->getProperties();

        $array = [];
        switch ($key) {
            case self::KEY_BY_PROPERTY_NAME:
                /** @var \ReflectionProperty $property */
                foreach ($properties as $property) {
                    $annotation = $this->reader->getPropertyAnnotation($property, Field::class);
                    if ($annotation instanceof Field) {
                        $array[$property->getName()] = $this->getPropertyValue($entity, $property);
                    }
                }
                break;
            case self::KEY_BY_FIELD_NAME:
            default:
                /** @var \ReflectionProperty $property */
                foreach ($properties as $property) {
                    $annotation = $this->reader->getPropertyAnnotation($property, Field::class);
                    if ($annotation instanceof Field) {
                        $array[$annotation->name] = $this->getPropertyValue($entity, $property);
                    }
                }
                break;
        }

        return $array;
    }

    /**
     * Set property value
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param \ReflectionProperty $property
     * @param mixed|null $value
     * @return void
     */
    public function setPropertyValue(?AbstractEntity $entity, \ReflectionProperty $property, $value = null)
    {
        $property->setAccessible(true);
        $property->setValue($entity, $value);
    }

    /**
     * Get property value
     *
     * @param \Bigcommerce\ORM\AbstractEntity|null $entity entity
     * @param \ReflectionProperty|null $property property
     * @return mixed
     */
    public function getPropertyValue(?AbstractEntity $entity, ?\ReflectionProperty $property)
    {
        if ($property instanceof \ReflectionProperty) {
            $property->setAccessible(true);

            return $property->getValue($entity);
        }

        return null;
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
     * Get property value by name
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param string $propertyName
     * @return mixed
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getPropertyValueByName(AbstractEntity $entity, string $propertyName)
    {
        $property = $this->getProperty($entity, $propertyName);

        return $this->getPropertyValue($entity, $property);
    }

    /**
     * Get value of a property by field name
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param string $fieldName
     * @return mixed
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getPropertyValueByFieldName(AbstractEntity $entity, $fieldName)
    {
        $reflectionClass = $this->reflect($entity);
        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            $annotation = $this->reader->getPropertyAnnotation($property, Field::class);
            if ($annotation instanceof Field && $annotation->name == $fieldName) {
                return $this->getPropertyValue($entity, $property);
            }
        }

        throw new MapperException(MapperException::ERROR_NO_FIELD_FOUND . $fieldName);
    }

    /**
     * Get enity property by property name
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity entity
     * @param string $propertyName name
     * @return bool|\ReflectionProperty
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getProperty(AbstractEntity $entity, string $propertyName)
    {
        $reflectionClass = $this->reflect($entity);
        $properties = $reflectionClass->getProperties();
        foreach ($properties as $property) {
            if ($property->name == $propertyName) {
                return $property;
            }
        }

        return false;
    }

    /**
     * Create Entity object from class name
     *
     * @param string $class class name
     * @return \Bigcommerce\ORM\AbstractEntity
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function object($class)
    {
        try {
            $object = new $class();
        } catch (\Throwable $exception) {
            throw new MapperException(MapperException::ERROR_INVALID_CLASS_NAME . $class);
        }

        return $object;
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity|null $entity
     * @return \ReflectionClass
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function reflect(AbstractEntity $entity = null)
    {
        try {
            $reflectionClass = new ReflectionClass(get_class($entity));
            $this->register();
        } catch (\Throwable $exception) {
            throw new MapperException(MapperException::ERROR_FAILED_TO_CREATE_REFLECT_CLASS . $exception->getMessage());
        }

        return $reflectionClass;
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity|null $entity
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function checkEntity(?AbstractEntity $entity)
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
     * @param \Bigcommerce\ORM\AbstractEntity|null $entity
     * @param array|null $autoIncludes
     * @param array|null $items
     * @param array|null $pathParams
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function patchAutoIncludes(?AbstractEntity $entity = null, ?array $autoIncludes = null, ?array $items = null, ?array $pathParams = null)
    {
        foreach ($autoIncludes as $fieldName => $include) {
            $property = $include['property'];
            $annotation = $include['annotation'];
            if (isset($items[$annotation->name])) {
                if ($annotation instanceof ManyRelationInterface) {
                    $propertyValue = $this->includesToCollection($annotation->targetClass, $items[$annotation->name], $pathParams);
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
                    if ($annotation->auto === true && $annotation->from == 'include') {
                        $includeFields[$annotation->name] = ['property' => $property, 'annotation' => $annotation];
                    }

                    if ($annotation->auto === true && $annotation->from == 'api') {
                        $autoLoadFields[$annotation->name] = ['property' => $property, 'annotation' => $annotation];
                    }

                    if ($annotation->from == 'result') {
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
     * Register annotation classes
     *
     * @return void
     */
    private function register()
    {
        if (class_exists(AnnotationRegistry::class)) {
            AnnotationRegistry::registerLoader('class_exists');
        }
    }
}
