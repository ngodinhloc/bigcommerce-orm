<?php

namespace Bigcommerce\ORM\Mapper;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations\Field;
use Bigcommerce\ORM\Exceptions\EntityException;
use Bigcommerce\ORM\Exceptions\MapperException;
use Doctrine\Common\Annotations\AnnotationReader;

class EntityReader
{
    /** @var \Doctrine\Common\Annotations\AnnotationReader */
    protected $reader;

    /**
     * EntityReader constructor.
     * @param \Doctrine\Common\Annotations\AnnotationReader|null $reader
     */
    public function __construct(?AnnotationReader $reader = null)
    {
        $this->reader = $reader ?: new AnnotationReader();
    }

    /**
     * Get value of a property by field name
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param string $fieldName
     * @return mixed
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getPropertyValueByFieldName(AbstractEntity $entity, string $fieldName)
    {
        $reflectionClass = (new Reflection())->reflect($entity);
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
     * Get property value
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity entity
     * @param \ReflectionProperty|null $property property
     * @return mixed
     */
    public function getPropertyValue(AbstractEntity $entity, ?\ReflectionProperty $property)
    {
        if ($property instanceof \ReflectionProperty) {
            $property->setAccessible(true);

            return $property->getValue($entity);
        }

        return null;
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
        $reflectionClass = (new Reflection())->reflect($entity);
        $properties = $reflectionClass->getProperties();
        foreach ($properties as $property) {
            if ($property->name == $propertyName) {
                return $property;
            }
        }

        return false;
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
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function getUploadFiles(AbstractEntity $entity)
    {
        $files = [];
        if (!empty($uploadFields = $entity->getMetadata()->getUploadFields())) {
            foreach ($uploadFields as $fieldName => $property) {
                $location = $this->getPropertyValue($entity, $property);
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
}
