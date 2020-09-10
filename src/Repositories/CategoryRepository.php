<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Repositories;

use Bigcommerce\ORM\Repository;

/**
 * Class CategoryRepository
 * @package Bigcommerce\ORM\Repositories
 */
class CategoryRepository extends Repository
{
    protected $className = \Bigcommerce\ORM\Entities\Customer::class;
}