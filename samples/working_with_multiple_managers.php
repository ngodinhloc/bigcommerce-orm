<?php
require_once('./vendor/autoload.php');

try {
    /** working with multiple stores */
    $firstCredential = include('_auth.php');

    $configuration = new Bigcommerce\ORM\Configuration($firstCredential);
    $firstEntityManger = $configuration->configEntityManager();

    $secondCredential = include('_basic.php');
    $configuration = new Bigcommerce\ORM\Configuration($secondCredential);
    $secondEntityManger = $configuration->configEntityManager();

    /** using ManagerFactory */
    $configs = [
        'firstStore' => [
            'credentials' => $firstCredential
        ],
        'secondStore' => [
            'credentials' => $secondCredential
        ],
    ];

    $managerFactory = new \Bigcommerce\ORM\ManagerFactory($configs);
    $firstStoreManager = $managerFactory->getEntityManager('firstStore');
    $secondStoreManager = $managerFactory->getEntityManager('secondStore');

} catch (\Exception $e) {
    echo $e->getMessage();
}