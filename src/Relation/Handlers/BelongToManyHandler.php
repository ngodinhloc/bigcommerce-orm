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
 * Class BelongToManyHandler
 * @package Bigcommerce\ORM\Relation\Handlers
 */
class BelongToManyHandler extends AbstractHandler implements RelationHandlerInterface
{
    /**
     * @param \Bigcommerce\ORM\Entity $entity entity
     * @param \ReflectionProperty $property property
     * @param \Bigcommerce\ORM\Relation\RelationInterface $annotation relation
     * @param array $data
     * @param int|null $parentId
     * @return void
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Exception
     */
    public function handle(Entity $entity, \ReflectionProperty $property, RelationInterface $annotation, array $data, int $parentId = null)
    {
        /* @var \Bigcommerce\ORM\Annotations\BelongToMany $annotation */
        if (!isset($annotation->field) || !isset($data[$annotation->field]) || empty($data[$annotation->field])) {
            return;
        }

        $value = $data[$annotation->field];
        if (!is_array($value)) {
            $value = [$value];
        }

        if (empty($parentId)) {
            $parentId = $entity->getId();
        }

        $mapper = $this->entityManager->getMapper();
        $queryBuilder = new QueryBuilder();
        $queryBuilder->whereIn($annotation->targetField, $value);

        $auto = $annotation->auto;
        /** BelongRelationInterface: force auto = false to prevent the loop (child -> parent -> child) */
        if ($annotation instanceof BelongToRelationInterface) {
            $auto = false;
        }

        $collections = $this->entityManager->findBy($annotation->targetClass, $parentId, $queryBuilder, $auto);
        $mapper->setPropertyValue($entity, $property, $collections);
    }
}
