<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Relation;

use Bigcommerce\ORM\Entity;

/**
 * Interface RelationHandlerInterface
 * @package Bigcommerce\ORM\Relation
 */
interface RelationHandlerInterface
{
    /**
     * @param \Bigcommerce\ORM\Entity $entity entity
     * @param \ReflectionProperty $property property
     * @param \Bigcommerce\ORM\Relation\RelationInterface $annotation relation
     * @param array $data
     * @param array|null $pathParams
     * @return \Bigcommerce\ORM\Entity
     */
    public function handle(Entity $entity, \ReflectionProperty $property, RelationInterface $annotation, array $data, array $pathParams = null);
}
