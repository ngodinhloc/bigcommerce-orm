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

    /** get one customer by id */
    /** @var \Bigcommerce\ORM\Entities\Customer $customer2 */
    $customer2 = $entityManager->find(\Bigcommerce\ORM\Entities\Customer::class, 1);
    $addresses2 = $customer2->getAddresses();
    $address2 = $addresses2[0];
    $country2 = $address2->getCountry();
    echo $country2 . PHP_EOL;

} catch (\Exception $e) {
    echo $e->getMessage();
}