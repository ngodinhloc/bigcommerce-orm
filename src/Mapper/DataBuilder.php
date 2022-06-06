<?php

namespace Bigcommerce\ORM\Mapper;

use Bigcommerce\ORM\Exceptions\EntityException;

class DataBuilder
{
    /** @var \Bigcommerce\ORM\Mapper\EntityMapper */
    protected $mapper;

    /**
     * DataBuilder constructor.
     * @param \Bigcommerce\ORM\Mapper\EntityMapper $mapper
     */
    public function __construct(EntityMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param string $className
     * @param \Bigcommerce\ORM\AbstractEntity[]|null $entities
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function buildBatchCreateData(string $className, ?array $entities = null)
    {
        $data = [];
        foreach ($entities as $entity) {
            if ($className != get_class($entity)) {
                throw new EntityException(EntityException::ERROR_DIFFERENT_CLASS_NAME);
            }

            $writableData = $this->mapper->getWritableFieldValues($entity);
            $data[] = $writableData;
        }

        return $data;
    }

    /**
     * @param string $className
     * @param \Bigcommerce\ORM\AbstractEntity[]|null $entities
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function buildBatchUpdateData(string $className, ?array &$entities = null)
    {
        $data = [];
        foreach ($entities as $entity) {
            if ($className != get_class($entity)) {
                throw new EntityException(EntityException::ERROR_DIFFERENT_CLASS_NAME);
            }

            if (empty($entity->getId())) {
                continue;
            }

            $writableData = $this->mapper->getWritableFieldValues($entity);
            $entities[$entity->getId()] = $entity;
            $data[] = array_merge($writableData, ['id' => $entity->getId()]);
        }

        return $data;
    }
}
