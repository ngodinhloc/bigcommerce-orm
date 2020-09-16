<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {

    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** count the number of categories */
    $count = $entityManager->count(\Bigcommerce\ORM\Entities\Category::class);
    echo $count . PHP_EOL;

    /** find all categories */
    $allCategories = $entityManager->findAll(\Bigcommerce\ORM\Entities\Category::class, null, null, true);
    echo count($allCategories) . PHP_EOL;

    /** find some categories by queries */
    $queryBuilder = new \Bigcommerce\ORM\QueryBuilder();
    $queryBuilder
        ->whereIn('id', [18, 21, 24])
        ->page(1)
        ->limit(50);
    $someCategories = $entityManager->findBy(\Bigcommerce\ORM\Entities\Category::class, null, $queryBuilder, true);
    echo count($someCategories) . PHP_EOL;

    /** find one category by id */
    $category24 = $entityManager->find(\Bigcommerce\ORM\Entities\Category::class, 24, null, true);
    /** @var \Bigcommerce\ORM\Entities\Category $category24 */
    $parent = $category24->getParent();
    $name24 = $category24->getName();
    echo $name24. PHP_EOL;

    /** update a category */
    $category24->setDescription('This is new description');
    $entityManager->save($category24);
    $newDescription = $category24->getDescription();
    echo $newDescription . PHP_EOL;

    /** find one product by id */
    $product111 = $entityManager->find(\Bigcommerce\ORM\Entities\Product::class, 111, null, true);
    /** @var \Bigcommerce\ORM\Entities\Product $product111 */
    $name111 = $product111->getName();
    $primaryImage111 = $product111->getPrimaryImage();
    $images111 = $product111->getImages();
    $categories111 = $product111->getCategories();
    $reviews111 = $product111->getReviews();
    echo $name111 . PHP_EOL;

} catch (\Exception $e) {
    echo $e->getMessage();
}
