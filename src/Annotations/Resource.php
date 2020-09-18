<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 */
class Resource extends Annotation
{
    public $name;
    public $path;
    public $findable = true;
    public $creatable = true;
    public $deletable = true;
}
