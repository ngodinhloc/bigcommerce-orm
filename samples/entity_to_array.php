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
    'debug' => true
];

try {
    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** create new object and set data */
    $review1 = new \Bigcommerce\ORM\Entities\ProductReview();
    $review1
        ->setProductId(111)
        ->setTitle('Great Product')
        ->setText('I love this product so much')
        ->setStatus('approved')
        ->setRating(5)
        ->setName('Ken Ngo')
        ->setEmail('ken.ngo@bigcommerce.com')
        ->setDateReviewed(date('c'));

    /** @var  $array1 */
    $array1 = $entityManager->toArray($review1, \Bigcommerce\ORM\Mapper::KEY_BY_FIELD_NAME);
    print_r($array1);

    $array2 = $entityManager->toArray($review1, \Bigcommerce\ORM\Mapper::KEY_BY_PROPERTY_NAME);
    print_r($array2);

} catch (\Exception $e) {
    echo $e->getMessage();
}