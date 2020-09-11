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
    'debug' => true,
    'proxy' => null
];

try {
    $cacheDir = __DIR__ . "/caches/";
    $cachePool = new \Bigcommerce\ORM\Cache\FileCache\FileCachePool($cacheDir);

    $eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
    $mySubscriber = new \Samples\Events\MySubscriber();
    $eventDispatcher->addSubscriber($mySubscriber);

    $logFile = __DIR__ . "/logs/monolog.log";
    $logger = new \Monolog\Logger('local_logger');
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($logFile));

    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options, $cachePool, $eventDispatcher, $logger);
    $entityManager = $config->configEntityManager();

} catch (\Exception $e) {
    echo $e->getMessage();
}