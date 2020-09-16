<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {
    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** standard repository */
    $customerRepo = new \Bigcommerce\ORM\Repositories\CustomerRepository($entityManager);
    $customers = $customerRepo->findAll();
    $customer = $customers[0];

    $count = $customerRepo->count();
    echo $count;

} catch (\Exception $e) {
    echo $e->getMessage();
}