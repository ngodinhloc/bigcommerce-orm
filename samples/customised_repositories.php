<?php
require_once('./vendor/autoload.php');

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

    /** customised repository */
    $myRepo = new \Samples\Repositories\MyRepository($entityManager);
    $count = $myRepo->count();
    echo $count . PHP_EOL;

    $myCustomers = $myRepo->getCustomerByName('Ken');
    /** @var \Bigcommerce\ORM\Entities\Customer $firstCustomer */
    $firstCustomer = $myCustomers[0];
    $name = $firstCustomer->getLastName();
    echo $name . PHP_EOL;

} catch (\Exception $e) {
    echo $e->getMessage();
}