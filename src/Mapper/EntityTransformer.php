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

    /** @var \Bigcommerce\ORM\Mapper\EntityPatcher */
    protected $entityPatcher;

    /**
     * EntityTransformer constructor.
     * @param \Doctrine\Common\Annotations\AnnotationReader|null $reader
     * @param \Bigcommerce\ORM\Mapper\EntityReader|null $entityReader
     */
    public function __construct(?AnnotationReader $reader = null, EntityReader $entityReader = null, EntityPatcher $entityPatcher = null)
    {
        $this->reader = $reader ?: new AnnotationReader();
        $this->entityReader = $entityReader ?? new EntityReader($this->reader);
        $this->entityPatcher = $entityPatcher ?? new EntityPatcher($this->reader);
    }

    /**
     * Get array of entity
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param int|null $key
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @see \Bigcommerce\ORM\Mapper\EntityTransformer::KEY_BY_FIELD_NAME
     * @see \Bigcommerce\ORM\Mapper\EntityTransformer::KEY_BY_PROPERTY_NAME
     */
    public function entityToArray(AbstractEntity $entity, ?int $key = self::KEY_BY_FIELD_NAME)
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

    /**
     * @param string $className
     * @param array|null $result
     * @param array|null $pathParams
     * @return \Bigcommerce\ORM\AbstractEntity[]|bool
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function batchCreateResultToEntities(string $className, ?array $result = null, ?array $pathParams = null)
    {
        $entities = [];
        foreach ($result as $item) {
            if (isset($item['id'])) {
                $entities[] = $this->entityPatcher->new($className, $item, $pathParams);
            } else {
                /** if any of the return data does not contain 'id' then return true */
                return true;
            }
        }

        return $entities;
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity[]|null $entities
     * @param array|null $result
     * @param array|null $pathParams
     * @return \Bigcommerce\ORM\AbstractEntity[]|bool
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function batchUpdateResultToEntities(?array $entities = null, ?array $result = null, ?array $pathParams = null)
    {
        $output = [];
        foreach ($result as $data) {
            if (isset($data['id']) && isset($entities[$data['id']])) {
                $entity = $entities[$data['id']];
                $output[] = $this->entityPatcher->patch($entity, $data, $pathParams, false);
            } else {
                /** if any of the return data does not contain 'id' then return true */
                return true;
            }
        }

        return $output;
    }
}
