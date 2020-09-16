<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

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