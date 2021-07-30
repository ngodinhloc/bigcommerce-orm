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
    public function __construct(?EntityManager $entityManager = null)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array|null $pathParams
     * @param array|null $orders
     * @param bool $auto
     * @return array|bool
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function findAll(?array $pathParams = null, ?array $orders = null, bool $auto = false)
    {
        $this->entityManager->getMapper()->getEntityValidator()->checkClass($this->className);

        return $this->entityManager->findAll($this->className, $pathParams, $orders, $auto);
    }

    /**
     * @param array|null $pathParams
     * @param \Bigcommerce\ORM\QueryBuilder|null $queryBuilder
     * @param bool $auto
     * @return array|false
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function findBy(?array $pathParams = null, ?QueryBuilder $queryBuilder = null, bool $auto = false)
    {
        $this->entityManager->getMapper()->getEntityValidator()->checkClass($this->className);

        return $this->entityManager->findBy($this->className, $pathParams, $queryBuilder, $auto);
    }

    /**
     * Find object by id
     *
     * @param int|string|null $id id
     * @param array|null $pathParams
     * @param bool $auto
     * @return \Bigcommerce\ORM\AbstractEntity
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function find($id = null, ?array $pathParams = null, $auto = false)
    {
        $this->entityManager->getMapper()->getEntityValidator()->checkClass($this->className);

        return $this->entityManager->find($this->className, $id, $pathParams, $auto);
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
     * @param \Bigcommerce\ORM\EntityManager|null $entityManager entity manager
     * @return \Bigcommerce\ORM\Repository
     */
    public function setEntityManager(?EntityManager $entityManager = null)
    {
        $this->entityManager = $entityManager;

        return $this;
    }
}
