<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {

    $logFile = __DIR__ . "/logs/monolog.log";
    $logger = new \Monolog\Logger('local_logger');
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($logFile));

    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options, null, null, $logger);
    $entityManager = $config->configEntityManager();

    /** count number of customers */
    $count = $entityManager->count(\Bigcommerce\ORM\Entities\Customer::class);
    echo $count . PHP_EOL;

    /** get all customers */
    $allCustomers = $entityManager->findAll(\Bigcommerce\ORM\Entities\Customer::class, null, ['date_created' => "asc"]);
    /** @var \Bigcommerce\ORM\Entities\Customer $customer1 */
    $customer1 = $allCustomers[0];
    echo $customer1->getLastName();

} catch (\Exception $e) {
    echo $e->getMessage();
}