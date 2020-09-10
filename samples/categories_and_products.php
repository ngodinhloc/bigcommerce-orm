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

    /** count the number of categories */
    $count = $entityManager->count(\Bigcommerce\ORM\Entities\Category::class);
    echo $count . PHP_EOL;

    /** get all categories */
    $allCategories = $entityManager->findAll(\Bigcommerce\ORM\Entities\Category::class, null, null, true);
    /** @var \Bigcommerce\ORM\Entities\Category $category1 */
    $category1 = $allCategories[0];
    $name1 = $category1->getName();
    echo $name1 . PHP_EOL;

    /** get some categories by queries */
    $queryBuilder = new \Bigcommerce\ORM\QueryBuilder();
    $queryBuilder
        ->whereIn('id', [18, 21, 24])
        ->page(1)
        ->limit(50);
    $someCategories = $entityManager->findBy(\Bigcommerce\ORM\Entities\Category::class, null, $queryBuilder, true);
    /** @var \Bigcommerce\ORM\Entities\Category $category2 */
    $category2 = $someCategories[1];
    $name2 = $category2->getName();
    echo $name2 . PHP_EOL;

    /** get one category by id */
    $category24 = $entityManager->find(\Bigcommerce\ORM\Entities\Category::class, 24, null, true);
    /** @var \Bigcommerce\ORM\Entities\Category $category24 */
    $parent = $category24->getParent();
    $name24 = $category24->getName();
    echo $name24;

    /** update a category */
    $category24->setDescription('This is new description');
    $entityManager->save($category24);
    $newDescription = $category24->getDescription();
    echo $newDescription . PHP_EOL;

    /** get one product  */
    $product111 = $entityManager->find(\Bigcommerce\ORM\Entities\Product::class, 111, null, true);
    /** @var \Bigcommerce\ORM\Entities\Product $product111 */
    $name111 = $product111->getName();
    $primaryImage111 = $product111->getPrimaryImage();
    $images111 = $product111->getImages();
    $categories111 = $product111->getCategories();
    $reviews111 = $product111->getReviews();
    echo $name111 . PHP_EOL;

    /** create a new product review */
    $newReview = new \Bigcommerce\ORM\Entities\ProductReview();
    $newReview
        ->setProductId($product111->getId())
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

    /** create new product image from url */
    $newImage = new \Bigcommerce\ORM\Entities\ProductImage();
    $newImage
        ->setProductId($product111->getId())
        ->setSortOrder(1)
        ->setDescription('New image by url')
        ->setImageUrl('https://upload.wikimedia.org/wikipedia/commons/9/9e/Xenon_short_arc_1.jpg');
    $entityManager->save($newImage);
    $urlZoom = $newImage->getUrlZoom();
    echo $urlZoom . PHP_EOL;

    /** create new product image with upload file */
    $file = __DIR__ . "/photos/lamp.jpg";
    $uploadImage = new \Bigcommerce\ORM\Entities\ProductImage();
    $uploadImage
        ->setProductId($product111->getId())
        ->setSortOrder(2)
        ->setDescription('New image by upload file')
        ->setImageFile($file);
    $entityManager->save($uploadImage);
    $urlZoomUpload = $uploadImage->getUrlZoom();
    echo $urlZoomUpload . PHP_EOL;

} catch (\Exception $e) {
    echo $e->getMessage();
}
