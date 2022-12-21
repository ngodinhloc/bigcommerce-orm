<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Repositories;

use Bigcommerce\ORM\Repository;

/**
 * Class ProductRepository
 * @package Bigcommerce\ORM\Repositories
 */
class ProductRepository extends Repository
{
    protected string $className = \Bigcommerce\ORM\Entities\Product::class;
}