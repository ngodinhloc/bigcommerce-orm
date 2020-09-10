<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 */
final class Field extends Annotation
{
    public $name;
    public $required = false;
    public $readonly = false;
    public $customised = false;
    public $parent = false;
    public $upload = false;
}
