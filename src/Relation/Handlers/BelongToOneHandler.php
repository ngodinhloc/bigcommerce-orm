<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Relation\Handlers;

use Bigcommerce\ORM\Entity;
use Bigcommerce\ORM\QueryBuilder;
use Bigcommerce\ORM\Relation\AbstractHandler;
use Bigcommerce\ORM\Relation\BelongToRelationInterface;
use Bigcommerce\ORM\Relation\RelationHandlerInterface;
use Bigcommerce\ORM\Relation\RelationInterface;

/**
 * Class BelongToOneHandler
 * @package Bigcommerce\ORM\Relation\Handlers
 */
class BelongToOneHandler extends AbstractHandler implements RelationHandlerInterface
{
    /**
     * @param \Bigcommerce\ORM\Entity $entity entity
     * @param \ReflectionProperty $property property
     * @param \Bigcommerce\ORM\Relation\RelationInterface $annotation relation
     * @param array $data
     * @param array|null $parentIds
     * @return void
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Exception
     */
    public function handle(Entity $entity, \ReflectionProperty $property, RelationInterface $annotation, array $data, array $parentIds = null)
    {
        /* @var \Bigcommerce\ORM\Annotations\BelongToOne $annotation */
        if (!isset($annotation->field) || !isset($data[$annotation->field]) || empty($data[$annotation->field])) {
            return;
        }

        $value = $data[$annotation->field];
        if (!is_array($value)) {
            $value = [$value];
        }

//        if (empty($parentIds)) {
//            $parentIds = $entity->getId();
//        }

        $mapper = $this->entityManager->getMapper();
        $queryBuilder = new QueryBuilder();
        $queryBuilder->whereIn($annotation->targetField, $value);

        $auto = $annotation->auto;
        /** BelongRelationInterface: force auto = false to prevent the loop (child -> parent -> child) */
        if ($annotation instanceof BelongToRelationInterface) {
            $auto = false;
        }

        $collections = $this->entityManager->findBy($annotation->targetClass, $parentIds, $queryBuilder, $auto);
        $mapper->setPropertyValue($entity, $property, $collections[0]);
    }
}
