<?php

namespace Bigcommerce\ORM\Mapper;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Relation\RelationInterface;

class Autoloader
{
    protected \Bigcommerce\ORM\EntityManager $entityManager;

    /**
     * Autoloader constructor.
     * @param \Bigcommerce\ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Load object in relations
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param array|null $data
     * @param array|null $pathParams
     * @return \Bigcommerce\ORM\AbstractEntity
     */
    public function autoLoad(AbstractEntity $entity, ?array $data = null, ?array $pathParams = null)
    {
        if (empty($autoLoadFields = $entity->getMetadata()->getAutoLoadFields())) {
            return $entity;
        }

        foreach ($autoLoadFields as $fieldName => $load) {
            $property = $load['property'];
            $annotation = $load['annotation'];

            if ($annotation instanceof RelationInterface) {
                $handler = $annotation->getHandler($this->entityManager);
                $handler->handle($entity, $property, $annotation, $data, $pathParams);
            }
        }

        return $entity;
    }
}
