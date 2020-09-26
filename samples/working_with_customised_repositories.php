<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

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