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

    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** count the number of product modifiers => an exception will be threw because parent id(s) are missing */
//    $count = $entityManager->count(\Bigcommerce\ORM\Entities\ProductModifier::class);

    /** count the number of product reviews : product_id = 111 */
    $count = $entityManager->count(\Bigcommerce\ORM\Entities\ProductModifier::class, ['product_id' => 111]);
    echo $count . PHP_EOL;

    /** find all product reviews => an exception will be threw because parent id(s) are missing */
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
