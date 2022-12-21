<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Repositories;

use Bigcommerce\ORM\Repository;

/**
 * Class CustomerRepository
 * @package Bigcommerce\ORM\Repositories
 */
class CustomerRepository extends Repository
{
    protected string $className = \Bigcommerce\ORM\Entities\Customer::class;
}