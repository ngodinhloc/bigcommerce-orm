<?php
require_once('./vendor/autoload.php');

$authCredentials = [
    'clientId' => 'acxu0p8rfh15m8n0fn4obuxmb52tgwk',
    'authToken' => 'cyfbhepc71mns8xnykv86wruxzh45wi',
    'storeHash' => 'e87g0h02r5',
    'baseUrl' => 'https://api.service.bcdev'
];

try {
    $config = new \Bigcommerce\ORM\Configuration($authCredentials);
    $entityManager = $config->configEntityManager();

    /** create new object and set data */
    $myProduct = new \Samples\Entities\MyProduct();
    $myProduct
        ->setMyCustomisedField('This is my field');
    $entityManager->patch($myProduct);
    echo $myProduct->getMyCustomisedField();

} catch (\Exception $e) {
    echo $e->getMessage();
}