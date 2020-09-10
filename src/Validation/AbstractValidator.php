<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Validation;

use Bigcommerce\ORM\Mapper;

/**
 * Class AbstractValidator
 * @package Bigcommerce\ORM\Validation
 */
abstract class AbstractValidator
{
    /** @var \Bigcommerce\ORM\Mapper */
    protected $mapper;

    /**
     * AbstractValidator constructor.
     *
     * @param \Bigcommerce\ORM\Mapper|null $mapper
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct(Mapper $mapper = null)
    {
        $this->mapper = $mapper ?: new Mapper();
    }
}
