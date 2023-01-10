<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Relation;

use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Exceptions\HandlerException;

/**
 * Class AbstractHandler
 * @package Bigcommerce\ORM\Relation
 */
abstract class AbstractHandler
{
    protected ?\Bigcommerce\ORM\EntityManager $entityManager;

    /**
     * AbstractHandler constructor.
     *
     * @param \Bigcommerce\ORM\EntityManager|null $entityManager
     */
    public function __construct(?EntityManager $entityManager = null)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param null $value
     * @return int|string
     * @throws \Bigcommerce\ORM\Exceptions\HandlerException
     */
    protected function getOneRelationValue($value = null)
    {
        if (is_int($value) || is_string($value)) {
            return $value;
        }

        throw new HandlerException(HandlerException::ERROR_INVALID_ONE_RELATION_VALUE . json_encode($value));
    }

    /**
     * @param null $value
     * @return array|int|string
     * @throws \Bigcommerce\ORM\Exceptions\HandlerException
     */
    protected function getManyRelationValue($value = null)
    {
        if (is_int($value) || is_string($value)) {
            return [$value];
        }

        if (is_array($value)) {
            foreach ($value as $item) {
                if (!is_int($item) && !is_string($item)) {
                    throw new HandlerException(HandlerException::ERROR_INVALID_MANY_RELATION_VALUE . json_encode($item));
                }
            }

            return $value;
        }

        throw new HandlerException(HandlerException::ERROR_INVALID_MANY_RELATION_VALUE . json_encode($value));
    }

    /**
     * @return \Bigcommerce\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param \Bigcommerce\ORM\EntityManager|null $entityManager
     * @return \Bigcommerce\ORM\Relation\AbstractHandler
     */
    public function setEntityManager(?EntityManager $entityManager): AbstractHandler
    {
        $this->entityManager = $entityManager;

        return $this;
    }

}
