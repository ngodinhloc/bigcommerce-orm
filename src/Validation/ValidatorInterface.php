<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Validation;

use Bigcommerce\ORM\AbstractEntity;

/**
 * Interface ValidatorInterface
 * @package Bigcommerce\ORM\Validation
 */
interface ValidatorInterface
{
    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity entity
     * @param \ReflectionProperty $property property
     * @param \Bigcommerce\ORM\Validation\ValidationInterface $annotation relation
     * @return bool
     */
    public function validate(AbstractEntity $entity, \ReflectionProperty $property, ValidationInterface $annotation);
}
