<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Validation;

use Bigcommerce\ORM\Mapper\EntityMapper;

/**
 * Interface ValidationInterface
 * @package Bigcommerce\ORM\Validation
 */
interface ValidationInterface
{
    /**
     * @param \Bigcommerce\ORM\Mapper\EntityMapper $mapper
     * @return \Bigcommerce\ORM\Validation\ValidatorInterface
     */
    public function getValidator(EntityMapper $mapper): ValidatorInterface;
}
