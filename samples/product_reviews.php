<?php
require_once('./vendor/autoload.php');

$authCredentials = [
    'clientId' => 'acxu0p8rfh15m8n0fn4obuxmb52tgwk',
    'authToken' => 'cyfbhepc71mns8xnykv86wruxzh45wi',
    'storeHash' => 'e87g0h02r5',
    'baseUrl' => 'https://api.service.bcdev'
];
$options = [
    'verify' => true,
    'timeout' => 60,
    'contentType' => 'application/json',
    'debug' => true,
    'proxy' => null
];

try {
    $cacheDir = __DIR__ . "/caches/";
    $cachePool = new \Bigcommerce\ORM\Cache\FileCache\FileCachePool($cacheDir);

    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options, $cachePool);
    $entityManager = $config->configEntityManager();

    /** count the number of product reviews => an exception will be threw because parent id(s) are missing */
//    $count = $entityManager->count(\Bigcommerce\ORM\Entities\ProductReview::class);

    /** count the number of product reviews : product_id = 111 */
    $count = $entityManager->count(\Bigcommerce\ORM\Entities\ProductReview::class, ['product_id' => 111]);
    echo $count . PHP_EOL;

    /** find all product reviews => an exception will be threw because parent id(s) are missing */
//    $allReviews = $entityManager->findAll(\Bigcommerce\ORM\Entities\ProductReview::class);

    $allReviews = $entityManager->findAll(\Bigcommerce\ORM\Entities\ProductReview::class, ['product_id' => 111], null, true);
    echo count($allReviews) . PHP_EOL;

    /** find some product reviews: 1, 2,3,49  */
    $queryBuilder = new \Bigcommerce\ORM\QueryBuilder();
    $queryBuilder
        ->whereIn('id', [1, 2, 3, 49])
        ->page(1)
        ->limit(50);
    $someReviews = $entityManager->findBy(\Bigcommerce\ORM\Entities\ProductReview::class, ['product_id' => 111], $queryBuilder, true);
    echo count($someReviews) . PHP_EOL;

    /** find one product review: 49 */
    $review49 = $entityManager->find(\Bigcommerce\ORM\Entities\ProductReview::class, 49, ['product_id' => 111], true);
    /** @var \Bigcommerce\ORM\Entities\ProductReview $review49 */
    echo $review49->getId() . PHP_EOL;

    /** update product review: 49 */
    $review49->setText('I like this product a lot');
    $entityManager->save($review49);
    echo $review49->getDateModified() . PHP_EOL;

    /** create a new product review */
    $newReview = new \Bigcommerce\ORM\Entities\ProductReview();
    $newReview
        ->setProductId(111)
        ->setTitle('Great Product')
        ->setText('I love product111 so much')
        ->setStatus('approved')
        ->setRating(5)
        ->setName('Ken Ngo')
        ->setEmail('ken.ngo@bigcommerce.com')
        ->setDateReviewed(date('c'));
    $entityManager->save($newReview);
    $dateCreated = $newReview->getDateCreated();
    echo $dateCreated . PHP_EOL;

    /** update review with data */
    $data = ['rating' => 3, 'text' => 'This product is ok. I rated it 3 ***'];
    $result = $entityManager->update($review49, $data);
    echo $result . PHP_EOL;

} catch (\Exception $e) {
    echo $e->getMessage();
}
