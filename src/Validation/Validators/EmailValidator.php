<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Validation\Validators;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Validation\AbstractValidator;
use Bigcommerce\ORM\Validation\ValidationInterface;
use Bigcommerce\ORM\Validation\ValidatorInterface;

/**
 * Class EmailValidator
 * @package Bigcommerce\ORM\Validation\Validators
 */
class EmailValidator extends AbstractValidator implements ValidatorInterface
{

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param \ReflectionProperty $property
     * @param \Bigcommerce\ORM\Validation\ValidationInterface $annotation
     * @return bool
     */
    public function validate(AbstractEntity $entity, \ReflectionProperty $property, ValidationInterface $annotation)
    {
        $email = $this->mapper->getEntityReader()->getPropertyValue($entity, $property);
        if ($email === null) {
            return true;
        }

        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
