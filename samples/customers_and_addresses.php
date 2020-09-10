<?php
require_once('./vendor/autoload.php');

$basicCredentials = [
    'storeUrl' => 'https://store-velgoi8q0k.mybigcommerce.com',
    'username' => 'test',
    'apiKey' => '2525df56477f58e5868c240ee5228b0b5d4367c4'
];

$authCredentials = [
    'clientId' => 'acxu0p8rfh15m8n0fn4obuxmb52tgwk',
    'authToken' => 'cyfbhepc71mns8xnykv86wruxzh45wi',
    'storeHash' => 'e87g0h02r5',
    'baseUrl' => 'https://api.service.bcdev'
];
$options = [
    'verify' => false,
    'timeout' => 60,
    'contentType' => 'application/json',
    'debug' => true
];

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

    /** get one customer by id */
    /** @var \Bigcommerce\ORM\Entities\Customer $customer3 */
    $customer3 = $entityManager->find(\Bigcommerce\ORM\Entities\Customer::class, 1);
    $addresses3 = $customer3->getAddresses();
    $address3 = $addresses3[0];
    $country3 = $address3->getCountry();
    echo $country3 . PHP_EOL;

} catch (\Exception $e) {
    echo $e->getMessage();
}
