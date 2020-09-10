<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 */
class BigObject extends Annotation
{
    public $name;
    public $path;
    public $parentField;
}
