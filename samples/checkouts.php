<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {

    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** get one check out by cart id = e9e687cd-6711-4a93-99a1-b7d5aa5ad122 */
    $checkout = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, 'e9e687cd-6711-4a93-99a1-b7d5aa5ad122', null, true);
    /** @var \Bigcommerce\ORM\Entities\Checkout $checkout */
    echo $checkout->getId();

} catch (\Exception $e) {
    echo $e->getMessage();
}
