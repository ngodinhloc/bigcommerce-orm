<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Relation\Handlers;

use Bigcommerce\ORM\AbstractEntity;
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
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param \ReflectionProperty $property
     * @param \Bigcommerce\ORM\Relation\RelationInterface $annotation
     * @param array $data
     * @param array|null $pathParams
     * @return void
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\HandlerException
     * @throws \Exception
     */
    public function handle(AbstractEntity $entity, \ReflectionProperty $property, RelationInterface $annotation, array $data, array $pathParams = null)
    {
        /* @var \Bigcommerce\ORM\Annotations\BelongToMany $annotation */
        if (!isset($annotation->field) || !isset($data[$annotation->field]) || empty($data[$annotation->field])) {
            return;
        }

        /** BelongRelationInterface: force auto = false to prevent the loop (child -> parent -> child) */
        if ($annotation instanceof BelongToRelationInterface) {
            $annotation->auto = false;
        }

        $value = $this->getManyRelationValue($data[$annotation->field]);
        $queryBuilder = new QueryBuilder();
        $queryBuilder->whereIn($annotation->targetField, $value);
        $collections = $this->entityManager->findBy($annotation->targetClass, $pathParams, $queryBuilder, $annotation->auto);
        $mapper = $this->entityManager->getMapper();
        $mapper->getEntityMapper()->setPropertyValue($entity, $property, $collections);
    }
}
