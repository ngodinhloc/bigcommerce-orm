<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Relation;

use Bigcommerce\ORM\AbstractEntity;

/**
 * Interface RelationHandlerInterface
 * @package Bigcommerce\ORM\Relation
 */
interface RelationHandlerInterface
{
    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity entity
     * @param \ReflectionProperty $property property
     * @param \Bigcommerce\ORM\Relation\RelationInterface $annotation relation
     * @param array $data
     * @param array|null $pathParams
     * @return \Bigcommerce\ORM\AbstractEntity
     */
    public function handle(AbstractEntity $entity, \ReflectionProperty $property, RelationInterface $annotation, array $data, array $pathParams = null);
}
