<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class MyProduct
 * @package Tests\Entities
 * @BC\Resource(path="/catalog/products")
 */
class MyProduct extends Entity
{
}