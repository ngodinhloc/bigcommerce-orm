<?php

declare(strict_types=1);

namespace Bigcommerce\ORM\Annotations;

use Bigcommerce\ORM\Mapper\EntityMapper;
use Bigcommerce\ORM\Validation\ValidationInterface;
use Bigcommerce\ORM\Validation\ValidatorInterface;
use Bigcommerce\ORM\Validation\Validators\EmailValidator;
use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 */
final class Email extends Annotation implements ValidationInterface
{
    public $validate = false;

    /**
     * @param \Bigcommerce\ORM\Mapper\EntityMapper $mapper
     * @return \Bigcommerce\ORM\Validation\ValidatorInterface
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function getValidator(EntityMapper $mapper): ValidatorInterface
    {
        return new EmailValidator($mapper);
    }
}
