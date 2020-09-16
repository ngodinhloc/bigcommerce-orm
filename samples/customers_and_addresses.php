<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {
    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** count number of customers */
    $count = $entityManager->count(\Bigcommerce\ORM\Entities\Customer::class);
    echo $count . PHP_EOL;

    /** get all customers */
    $allCustomers = $entityManager->findAll(\Bigcommerce\ORM\Entities\Customer::class);
    /** @var \Bigcommerce\ORM\Entities\Customer $customer1 */
    $customer1 = $allCustomers[0];
    $name1 = $customer1->getFirstName();
    $addresses1 = $customer1->getAddresses();
    $address1 = $addresses1[0];
    $country1 = $address1->getCountry();
    echo $country1 . PHP_EOL;

    /** get some customers by queries */
    $queryBuilder = new \Bigcommerce\ORM\QueryBuilder();
    $queryBuilder
        ->whereIn('id', [1, 2])
//    ->whereEqual('id', 1) : customer does not allow to filter  id =
        ->whereLike('name', 'Ken1')
        ->page(1)->limit(50)
        ->orderBy('date_created', 'desc')
        ->order(['last_name' => 'asc']);
    $someCustomers = $entityManager->findBy(\Bigcommerce\ORM\Entities\Customer::class, null, $queryBuilder);
    /** @var \Bigcommerce\ORM\Entities\Customer $customer2 */
    $customer2 = $someCustomers[0];
    $name2 = $customer2->getFirstName();
    $addresses2 = $customer2->getAddresses();
    $address2 = $addresses2[0];
    $country2 = $address2->getCountry();
    echo $country2 . PHP_EOL;

    /** get one customer by id: you can't get customer by id (for privacy reason?) */

} catch (\Exception $e) {
    echo $e->getMessage();
}
