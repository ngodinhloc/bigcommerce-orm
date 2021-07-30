<?php

namespace Bigcommerce\ORM\Mapper;

use Bigcommerce\ORM\AbstractEntity;

class EntityReader
{
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
