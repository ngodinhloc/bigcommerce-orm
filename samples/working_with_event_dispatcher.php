<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {
    $eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
    $mySubscriber = new \Samples\Events\MySubscriber();
    $eventDispatcher->addSubscriber($mySubscriber);

    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options, null, $eventDispatcher, null);
    $entityManager = $config->configEntityManager();

    /** create a new product review */
    $newReview = new \Bigcommerce\ORM\Entities\ProductReview();
    $newReview
        ->setProductId(111)
        ->setTitle('Great Product')
        ->setText('I love this product so much')
        ->setStatus('approved')
        ->setRating(5)
        ->setName('Ken Ngo')
        ->setEmail('ken.ngo@bigcommerce.com')
        ->setDateReviewed(date('c'));
    $entityManager->save($newReview);
    $dateCreated = $newReview->getDateCreated();
    echo $dateCreated . PHP_EOL;

    /** update review */
    $newReview->setText('I love this product even more');
    $entityManager->save($newReview);
    $dateCreated = $newReview->getDateCreated();
    echo $dateCreated . PHP_EOL;

} catch (\Exception $e) {
    echo $e->getMessage();
}