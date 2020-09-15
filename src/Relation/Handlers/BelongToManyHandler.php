<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Relation\Handlers;

use Bigcommerce\ORM\Entity;
use Bigcommerce\ORM\QueryBuilder;
use Bigcommerce\ORM\Relation\AbstractHandler;
use Bigcommerce\ORM\Relation\Handlers\Exceptions\HandlerException;
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
     * @param array|null $pathParams
     * @return void
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Relation\Handlers\Exceptions\HandlerException
     * @throws \Exception
     */
    public function handle(Entity $entity, \ReflectionProperty $property, RelationInterface $annotation, array $data, array $pathParams = null)
    {
        /* @var \Bigcommerce\ORM\Annotations\BelongToMany $annotation */
        if (!isset($annotation->field) || !isset($data[$annotation->field]) || empty($data[$annotation->field])) {
            return;
        }

        $value = $this->getManyRelationValue($data[$annotation->field]);
        /** BelongRelationInterface: force auto = false to prevent the loop (child -> parent -> child) */
        $auto = false;
        $queryBuilder = new QueryBuilder();
        $queryBuilder->whereIn($annotation->targetField, $value);
        $collections = $this->entityManager->findBy($annotation->targetClass, $pathParams, $queryBuilder, $auto);
        $mapper = $this->entityManager->getMapper();
        $mapper->setPropertyValue($entity, $property, $collections);
    }
}
