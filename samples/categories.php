<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {

    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** find all categories */
    $allCategories = $entityManager->findAll(\Bigcommerce\ORM\Entities\Category::class, null, null, true);
    echo count($allCategories) . PHP_EOL;

    /** find some categories by queries */
    $queryBuilder = new \Bigcommerce\ORM\QueryBuilder();
    $queryBuilder
        ->whereIn('id', [18, 21])
        ->page(1)
        ->limit(50);
    $someCategories = $entityManager->findBy(\Bigcommerce\ORM\Entities\Category::class, null, $queryBuilder, true);
    echo count($someCategories) . PHP_EOL;

    /** find one category by id */
    $category21 = $entityManager->find(\Bigcommerce\ORM\Entities\Category::class, 21, null, true);
    /** @var \Bigcommerce\ORM\Entities\Category $category21 */
    $parent = $category21->getParent();
    $name24 = $category21->getName();
    echo $name24 . PHP_EOL;

    /** update a category */
    $category21->setDescription('This is new description');
    $entityManager->save($category21);
    $newDescription = $category21->getDescription();
    echo $newDescription . PHP_EOL;

    /** create new category with parent = 21 */
    $newCategory = new \Bigcommerce\ORM\Entities\Category();
    $newCategory
        ->setName('Cooking Stuffs 1')
        ->setSortOrder(1)
        ->setParentId(21)
        ->setPageTitle('Cooking Stuffs')
        ->setDescription('Cooking Stuffs');
    $entityManager->save($newCategory);
    echo $newCategory->getId();

    /** remove newly created category */
    $deleted = $entityManager->delete(\Bigcommerce\ORM\Entities\Category::class, null, [$newCategory->getId()]);
    echo $deleted;

} catch (\Exception $e) {
    echo $e->getMessage();
}
