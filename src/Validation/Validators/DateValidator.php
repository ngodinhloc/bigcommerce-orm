<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Validation\Validators;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Validation\AbstractValidator;
use Bigcommerce\ORM\Validation\ValidationInterface;
use Bigcommerce\ORM\Validation\ValidatorInterface;

/**
 * Class DateValidator
 * @package Bigcommerce\ORM\Validation\Validators
 */
class DateValidator extends AbstractValidator implements ValidatorInterface
{

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param \ReflectionProperty $property
     * @param \Bigcommerce\ORM\Validation\ValidationInterface $annotation
     * @return bool
     */
    public function validate(AbstractEntity $entity, \ReflectionProperty $property, ValidationInterface $annotation)
    {
        $date = $this->mapper->getEntityReader()->getPropertyValue($entity, $property);
        if ($date === null) {
            return true;
        }
        /** @var \Bigcommerce\ORM\Annotations\Date $annotation */
        $date = date_parse_from_format($annotation->format, $date);

        return checkdate($date['month'], $date['day'], $date['year']);
    }
}
