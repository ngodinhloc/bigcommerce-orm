<?php
declare(strict_types=1);

namespace Bigcommerce\ORM;

/**
 * Class Repository
 * @package Bigcommerce\ORM
 */
class Repository
{

    /* @var string */
    protected $className;

    /** @var \Bigcommerce\ORM\EntityManager */
    protected $entityManager;

    /**
     * Repository constructor.
     *
     * @param \Bigcommerce\ORM\EntityManager|null $entityManager
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct(EntityManager $entityManager = null)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int|null $parentId
     * @return false|int
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function count(int $parentId = null)
    {
        return $this->entityManager->count($this->className, $parentId);
    }

    /**
     * @param int|null $parentId
     * @param array|null $orders
     * @param bool $auto
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function findAll(int $parentId = null, array $orders = null, bool $auto = false)
    {
        $this->entityManager->getMapper()->checkClass($this->className);

        return $this->entityManager->findAll($this->className, $parentId, $orders, $auto);
    }

    /**
     * @param int|null $parentId
     * @param \Bigcommerce\ORM\QueryBuilder|null $queryBuilder
     * @param bool $auto
     * @return array|false
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function findBy(int $parentId = null, QueryBuilder $queryBuilder = null, bool $auto = false)
    {
        $this->entityManager->getMapper()->checkClass($this->className);

        return $this->entityManager->findBy($this->className, $parentId, $queryBuilder, $auto);
    }

    /**
     * Find object by id
     *
     * @param int $id id
     * @param int|null $parentId
     * @param bool $auto
     * @return \Bigcommerce\ORM\Entity
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function find(int $id, int $parentId = null, $auto = false)
    {
        $this->entityManager->getMapper()->checkClass($this->className);

        return $this->entityManager->find($this->className, $id, $parentId, $auto);
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className class name
     * @return \Bigcommerce\ORM\Repository
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param \Bigcommerce\ORM\EntityManager $entityManager entity manager
     * @return \Bigcommerce\ORM\Repository
     */
    public function setEntityManager(EntityManager $entityManager = null)
    {
        $this->entityManager = $entityManager;

        return $this;
    }
}
