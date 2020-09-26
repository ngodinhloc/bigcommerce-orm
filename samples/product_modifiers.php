<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {
    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** find all product reviews => an exception will be threw because path params are missing */
//    $allReviews = $entityManager->findAll(\Bigcommerce\ORM\Entities\ProductReview::class);

    $allModifiers = $entityManager->findAll(\Bigcommerce\ORM\Entities\ProductModifier::class, ['product_id' => 111], null, true);
    echo count($allModifiers) . PHP_EOL;

    /** find some product modifiers: 115, 116  */
    $queryBuilder = new \Bigcommerce\ORM\QueryBuilder();
    $queryBuilder
        ->page(1)
        ->limit(50);
    $someModifiers = $entityManager->findBy(\Bigcommerce\ORM\Entities\ProductModifier::class, ['product_id' => 111], $queryBuilder, true);
    echo count($someModifiers) . PHP_EOL;

    /** find one product modifier: 116 */
    $modifier116 = $entityManager->find(\Bigcommerce\ORM\Entities\ProductModifier::class, 116, ['product_id' => 111], true);
    /** @var \Bigcommerce\ORM\Entities\ProductModifier $modifier116 */
    echo $modifier116->getId() . PHP_EOL;

    /** update product modifier: 115 */
    $modifier116->setDisplayName('Another Modifier Upload Photos');
    $entityManager->save($modifier116);
    echo $modifier116->getName() . PHP_EOL;

    /** create a new product modifier */
    $newModifier = new \Bigcommerce\ORM\Entities\ProductModifier();
    $newModifier
        ->setProductId(111)
        ->setDisplayName('Another Modifier')
        ->setType('file')
        ->setSortOrder(2)
        ->setConfig([])
        ->setOptionValues([]);

    $entityManager->save($newModifier);
    $id = $newModifier->getId();
    echo $id . PHP_EOL;

    /** update modifier with data */
    $data = ['name' => 'Updated Modifier', 'required' => true];
    $result = $entityManager->update($modifier116, $data);
    echo $result . PHP_EOL;


} catch (\Exception $e) {
    echo $e->getMessage();
}
