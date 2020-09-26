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
    $isPatch1 = $review1->isPatched();
    echo $isPatch1 . PHP_EOL;

    /** create object using EntityManager */
    $data = [
        'product_id' => 111,
        'title' => 'Very good product',
        'text' => 'I love this product a lot',
        'status' => 'approved',
        'rating' => 5,
        'name' => 'Ken Ngo',
        'email' => 'ken.ngo@bigcommerce.com',
        'date_reviewed' => date('c')
    ];
    $review2 = $entityManager->new(\Bigcommerce\ORM\Entities\ProductReview::class, $data);
    $isPatch2 = $review2->isPatched();
    echo $isPatch2 . PHP_EOL;

    /** create new entity then patch it with data */
    $review3 = new \Bigcommerce\ORM\Entities\ProductReview();
    $review3 = $entityManager->patch($review3, $data);
    $isPatch3 = $review3->isPatched();
    echo $isPatch3 . PHP_EOL;

    /** entity to array */
    $array1 = $entityManager->toArray($review1, \Bigcommerce\ORM\Mapper::KEY_BY_FIELD_NAME);
    print_r($array1);

    $array2 = $entityManager->toArray($review1, \Bigcommerce\ORM\Mapper::KEY_BY_PROPERTY_NAME);
    print_r($array2);

} catch (\Exception $e) {
    echo $e->getMessage();
}