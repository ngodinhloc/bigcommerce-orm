<?php
require_once('./vendor/autoload.php');

$basicCredentials = include('_basic.php');
$authCredentials = include('_auth.php');

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