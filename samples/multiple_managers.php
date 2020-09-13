<?php
require_once('./vendor/autoload.php');

try {
    /** working with multiple stores */
    $firstCredential = [
        'storeUrl' => 'https://store-velgoi8q0k.mybigcommerce.com',
        'username' => 'test',
        'apiKey' => '2525df56477f58e5868c240ee5228b0b5d4367c4'
    ];

    $configuration = new Bigcommerce\ORM\Configuration($firstCredential);
    $firstEntityManger = $configuration->configEntityManager();

    $secondCredential = [
        'clientId' => 'acxu0p8rfh15m8n0fn4obuxmb52tgwk',
        'authToken' => 'cyfbhepc71mns8xnykv86wruxzh45wi',
        'storeHash' => 'e87g0h02r5',
        'baseUrl' => 'https://api.service.bcdev'
    ];
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