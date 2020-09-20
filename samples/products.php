<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {

    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** find all products */
    $allProducts = $entityManager->findAll(\Bigcommerce\ORM\Entities\Product::class, null, null, false);
    echo count($allProducts) . PHP_EOL;

    /** find some product by queries */
    $queryBuilder = new \Bigcommerce\ORM\QueryBuilder();
    $queryBuilder
        ->whereIn('id', [77, 80, 111])
        ->page(1)
        ->limit(50);
    $someProducts = $entityManager->findBy(\Bigcommerce\ORM\Entities\Product::class, null, $queryBuilder, false);
    echo count($someProducts) . PHP_EOL;

//    /** Batch update products */
//    /** @var \Bigcommerce\ORM\Entities\Product $product1 */
//    $product1 = $someProducts[0];
//    $product2 = $someProducts[1];
//    $product1->setDescription('New Description');
//    $product2->setDescription('New Description');
//    $entityManager->batchUpdate([$product1, $product2]);

    /** find one product by id */
    $product111 = $entityManager->find(\Bigcommerce\ORM\Entities\Product::class, 111, null, true);
    /** @var \Bigcommerce\ORM\Entities\Product $product111 */
    $name111 = $product111->getName();
    $primaryImage111 = $product111->getPrimaryImage();
    $images111 = $product111->getImages();
    $categories111 = $product111->getCategories();
    $reviews111 = $product111->getReviews();
    echo $name111 . PHP_EOL;

    /** find one product by id 77 */
    $product77 = $entityManager->find(\Bigcommerce\ORM\Entities\Product::class, 77, null, true);
    /** @var \Bigcommerce\ORM\Entities\Product $product77 */
    echo $product77->getId();

//    /** update product */
//    $product111->setDescription('This is product 111 description');
//    $entityManager->save($product111);
//    echo $product111->getDateModified();

    /** create one product */
    $newProduct = new \Bigcommerce\ORM\Entities\Product();
    $newProduct
        ->setDescription('New product description')
        ->setName('New Product 2')
        ->setType('digital')
        ->setWeight(1)
        ->setWidth(10)
        ->setDepth(5)
        ->setHeight(20)
        ->setSku('sku2')
        ->setPrice(100)
        ->setBrandId(0)
        ->setCategoryIds([18, 21]);
    $entityManager->save($newProduct);
    echo $newProduct->getId();

    /** you can't batch create products */

} catch (\Exception $e) {
    echo $e->getMessage();
}
