<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Repositories;

use Bigcommerce\ORM\Repository;

/**
 * Class ProductImageRepository
 * @package Bigcommerce\ORM\Repositories
 */
class ProductImageRepository extends Repository
{
    protected $className = \Bigcommerce\ORM\Entities\ProductImage::class;
}