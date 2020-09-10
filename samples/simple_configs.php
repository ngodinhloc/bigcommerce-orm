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

try {
    /** Legacy credentials */
    $config = new \Bigcommerce\ORM\Configuration($basicCredentials);
    $entityManager = $config->configEntityManager();

    /** Auth credentials */
    $config = new \Bigcommerce\ORM\Configuration($authCredentials);
    $entityManager = $config->configEntityManager();

} catch (\Exception $e) {
    echo $e->getMessage();
}