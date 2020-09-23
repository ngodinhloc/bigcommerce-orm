<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Relation\Handlers;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\QueryBuilder;
use Bigcommerce\ORM\Relation\AbstractHandler;
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
     * @param \ReflectionProperty $property property
     * @param \Bigcommerce\ORM\Relation\RelationInterface $annotation relation
     * @param array $data
     * @param array|null $pathParams
     * @return void
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Relation\Handlers\Exceptions\HandlerException
     * @throws \Exception
     */
    public function handle(AbstractEntity $entity, \ReflectionProperty $property, RelationInterface $annotation, array $data, array $pathParams = null)
    {
        /* @var \Bigcommerce\ORM\Annotations\BelongToMany $annotation */
        if (!isset($annotation->field) || !isset($data[$annotation->field]) || empty($data[$annotation->field])) {
            return;
        }

        $value = $this->getManyRelationValue($data[$annotation->field]);
        $queryBuilder = new QueryBuilder();
        $queryBuilder->whereIn($annotation->targetField, $value);
        /** BelongRelationInterface: force auto = false to prevent the loop (child -> parent -> child) */
        $collections = $this->entityManager->findBy($annotation->targetClass, $pathParams, $queryBuilder, false);
        $mapper = $this->entityManager->getMapper();
        $mapper->setPropertyValue($entity, $property, $collections);
    }
}
