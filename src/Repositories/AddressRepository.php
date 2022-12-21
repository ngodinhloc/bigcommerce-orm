<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Repositories;

use Bigcommerce\ORM\Repository;

/**
 * Class AddressRepository
 * @package Bigcommerce\ORM\Repositories
 */
class AddressRepository extends Repository
{
    protected string $className = \Bigcommerce\ORM\Entities\CustomerAddress::class;
}