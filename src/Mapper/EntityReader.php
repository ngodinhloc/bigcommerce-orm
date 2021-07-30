<?php

namespace Bigcommerce\ORM\Mapper;

use Bigcommerce\ORM\AbstractEntity;

class EntityReader
{
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
}
