<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {
    $cacheDir = __DIR__ . "/caches/";
    $cachePool = new \Bigcommerce\ORM\Cache\FileCache\FileCachePool($cacheDir);

    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options, $cachePool);
    $entityManager = $config->configEntityManager();

    /** find one product by id */
    $product111 = $entityManager->find(\Bigcommerce\ORM\Entities\Product::class, 111, null, true);
    /** @var \Bigcommerce\ORM\Entities\Product $product111 */
    $name111 = $product111->getName();
    $primaryImage111 = $product111->getPrimaryImage();
    $images111 = $product111->getImages();
    $categories111 = $product111->getCategories();
    $reviews111 = $product111->getReviews();
    echo $name111 . PHP_EOL;

    /** create new product image from url */
    $newImage = new \Bigcommerce\ORM\Entities\ProductImage();
    $newImage
        ->setProductId($product111->getId())
        ->setSortOrder(1)
        ->setDescription('New image by url')
        ->setImageUrl('https://img.vntg.com/large/15687120107881/kosta-boda-glass-table-lamp-by-ove-sandeberg-sweden.jpg');
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
