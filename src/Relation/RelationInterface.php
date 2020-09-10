<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Relation;

use Bigcommerce\ORM\EntityManager;

/**
 * Interface RelationInterface
 * @package Bigcommerce\ORM\Relation
 */
interface RelationInterface
{
    /**
     * @param \Bigcommerce\ORM\EntityManager $entityManager entity manager
     * @return \Bigcommerce\ORM\Relation\RelationHandlerInterface
     */
    public function getHandler(EntityManager $entityManager): RelationHandlerInterface;
}
