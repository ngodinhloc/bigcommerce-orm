<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

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