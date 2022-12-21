<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Validation;

use Bigcommerce\ORM\Mapper\EntityMapper;

/**
 * Class AbstractValidator
 * @package Bigcommerce\ORM\Validation
 */
abstract class AbstractValidator
{
    protected \Bigcommerce\ORM\Mapper\EntityMapper $mapper;

    /**
     * AbstractValidator constructor.
     *
     * @param \Bigcommerce\ORM\Mapper\EntityMapper|null $mapper
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct(EntityMapper $mapper = null)
    {
        $this->mapper = $mapper ?: new EntityMapper();
    }

    /**
     * @return \Bigcommerce\ORM\Mapper\EntityMapper
     */
    public function getMapper(): \Bigcommerce\ORM\Mapper\EntityMapper
    {
        return $this->mapper;
    }

    /**
     * @param \Bigcommerce\ORM\Mapper\EntityMapper|null $mapper
     * @return \Bigcommerce\ORM\Validation\AbstractValidator
     */
    public function setMapper(?EntityMapper $mapper = null): AbstractValidator
    {
        $this->mapper = $mapper;

        return $this;
    }

}
