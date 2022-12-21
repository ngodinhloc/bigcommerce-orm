<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Repositories;

use Bigcommerce\ORM\Repository;

/**
 * Class ProductReviewRepository
 * @package Bigcommerce\ORM\Repositories
 */
class ProductReviewRepository extends Repository
{
    protected string $className = \Bigcommerce\ORM\Entities\ProductReview::class;
}