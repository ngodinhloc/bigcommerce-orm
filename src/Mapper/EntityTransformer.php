<?php

namespace Bigcommerce\ORM\Mapper;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations\Field;
use Doctrine\Common\Annotations\AnnotationReader;

class EntityTransformer
{
    const KEY_BY_FIELD_NAME = 1;
    const KEY_BY_PROPERTY_NAME = 2;

    /** @var \Doctrine\Common\Annotations\AnnotationReader */
    protected $reader;

    /** @var \Bigcommerce\ORM\Mapper\EntityReader */
    protected $entityReader;

    /**
     * EntityTransformer constructor.
     * @param \Doctrine\Common\Annotations\AnnotationReader|null $reader
     */
    public function __construct(?AnnotationReader $reader = null)
    {
        $this->reader = $reader ?: new AnnotationReader();
        $this->entityReader = new EntityReader($this->reader);
    }

    /**
     * Get array of entity
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param int|null $key
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @see \Bigcommerce\ORM\Mapper::KEY_BY_FIELD_NAME
     * @see \Bigcommerce\ORM\Mapper::KEY_BY_PROPERTY_NAME
     */
    public function toArray(AbstractEntity $entity, ?int $key = self::KEY_BY_FIELD_NAME)
    {
        $reflectionClass = (new Reflection())->reflect($entity);
        $properties = $reflectionClass->getProperties();

        $array = [];
        switch ($key) {
            case self::KEY_BY_PROPERTY_NAME:
                /** @var \ReflectionProperty $property */
                foreach ($properties as $property) {
                    $annotation = $this->reader->getPropertyAnnotation($property, Field::class);
                    if ($annotation instanceof Field) {
                        $array[$property->getName()] = $this->entityReader->getPropertyValue($entity, $property);
                    }
                }
                break;
            case self::KEY_BY_FIELD_NAME:
            default:
                /** @var \ReflectionProperty $property */
                foreach ($properties as $property) {
                    $annotation = $this->reader->getPropertyAnnotation($property, Field::class);
                    if ($annotation instanceof Field) {
                        $array[$annotation->name] = $this->entityReader->getPropertyValue($entity, $property);
                    }
                }
                break;
        }

        return $array;
    }
}
