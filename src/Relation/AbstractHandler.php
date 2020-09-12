<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Relation;

use Bigcommerce\ORM\EntityManager;

/**
 * Class AbstractHandler
 * @package Bigcommerce\ORM\Relation
 */
abstract class AbstractHandler
{
    /** @var \Bigcommerce\ORM\EntityManager */
    protected $entityManager;

    /**
     * AbstractHandler constructor.
     *
     * @param \Bigcommerce\ORM\EntityManager $entityManager entity manager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Bigcommerce\ORM\EntityManager
     */
    public function getEntityManager(): \Bigcommerce\ORM\EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @param \Bigcommerce\ORM\EntityManager $entityManager
     * @return \Bigcommerce\ORM\Relation\AbstractHandler
     */
    public function setEntityManager(\Bigcommerce\ORM\EntityManager $entityManager): AbstractHandler
    {
        $this->entityManager = $entityManager;
        return $this;
    }

}
