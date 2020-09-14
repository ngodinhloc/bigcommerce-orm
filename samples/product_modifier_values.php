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

    /** find one product modifier: 116 */
    $modifier116 = $entityManager->find(\Bigcommerce\ORM\Entities\ProductModifier::class, 116, ['product_id' => 111], true);
    /** @var \Bigcommerce\ORM\Entities\ProductModifier $modifier116 */
    echo $modifier116->getId() . PHP_EOL;

    /** count the number of product modifier values : product_id = 111, option_id = 116 */
    $count = $entityManager->count(\Bigcommerce\ORM\Entities\ProductModifierValue::class, ['product_id' => 111, 'option_id' => 116]);
    echo $count . PHP_EOL;

    /** find all product modifier values => an exception will be threw because path params are missing */
//    $allModifierValues = $entityManager->findAll(\Bigcommerce\ORM\Entities\ProductModifierValue::class, ['product_id' => 111]);

    $allModifierValues = $entityManager->findAll(\Bigcommerce\ORM\Entities\ProductModifierValue::class, ['product_id' => 111, 'option_id' => 116], null, true);
    echo count($allModifierValues) . PHP_EOL;

    /** find one product modifier value: 103 */
    $modifierValue103 = $entityManager->find(\Bigcommerce\ORM\Entities\ProductModifierValue::class, 103, ['product_id' => 111, 'option_id' => 116]);
    /** @var \Bigcommerce\ORM\Entities\ProductModifierValue $modifierValue103 */
    echo $modifierValue103->getId() . PHP_EOL;

    /** update product modifier value: 103 */
    $modifierValue103->setLabel('XS');
    $entityManager->save($modifierValue103);
    echo $modifierValue103->getLabel() . PHP_EOL;

    /** create a new modifier value: product_id = 111, option_id = 116 */
    $newValue = new \Bigcommerce\ORM\Entities\ProductModifierValue();
    $newValue
        ->setProductId(111)
        ->setModifierId(116)
        ->setLabel('S')
        ->setSortOrder(1)
        ->setIsDefault(false)
        ->setAdjusters([]);
    $entityManager->save($newValue);
    echo $newValue->getId();

} catch (\Exception $e) {
    echo $e->getMessage();
}