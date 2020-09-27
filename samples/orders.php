<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {
    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** find all transactions of order 156 */
    $transactions = $entityManager->findAll(\Bigcommerce\ORM\Entities\OrderTransaction::class, ['order_id' => 156], null, true);
    echo count($transactions);
} catch (\Exception $e) {
    echo $e->getMessage();
}
