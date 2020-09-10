<?php
declare(strict_types=1);

namespace Samples\Repositories;

use Bigcommerce\ORM\Entities\Customer;
use Bigcommerce\ORM\Repositories\CustomerRepository;

class MyRepository extends CustomerRepository
{
    /**
     * @param string $name
     * @return array|false
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getCustomerByName(string $name)
    {
        /** get some customers by name */
        $queryBuilder = new \Bigcommerce\ORM\QueryBuilder();
        $queryBuilder
            ->whereLike('name', $name)
            ->page(1)->limit(50)
            ->orderBy('date_created', 'desc')
            ->order(['last_name' => 'asc']);
        return $this->entityManager->findBy(Customer::class, null, $queryBuilder);
    }
}