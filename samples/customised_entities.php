<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {
    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
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