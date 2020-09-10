<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Validation;

use Bigcommerce\ORM\Mapper;

/**
 * Interface ValidationInterface
 * @package Bigcommerce\ORM\Validation
 */
interface ValidationInterface
{
    /**
     * @param \Bigcommerce\ORM\Mapper $mapper
     * @return \Bigcommerce\ORM\Validation\ValidatorInterface
     */
    public function getValidator(Mapper $mapper): ValidatorInterface;
}
