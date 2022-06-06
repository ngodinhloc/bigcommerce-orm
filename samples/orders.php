<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');
$customerId = 1;

try {
    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** create cart with one digital line item */
    $newCart = new \Bigcommerce\ORM\Entities\Cart();
    $newCart->setCustomerId($customerId);

    $lineItem = new \Bigcommerce\ORM\Entities\LineItem();
    $lineItem
        ->setProductId(111)
        ->setQuantity(1);

    $newCart->addLineItem($lineItem);
    $result = $entityManager->save($newCart);
    echo "Created Cart ID: {$newCart->getId()}" . PHP_EOL;
    echo "Line Item Count:" . count($newCart->getLineItems()) . PHP_EOL;

    /** find checkout of the created cart */
    $checkout = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, $newCart->getId(), null, true);

    /** Add billing address */
    $newBillingAddress = new \Bigcommerce\ORM\Entities\BillingAddress();
    $newBillingAddress
        ->setCheckoutId($checkout->getId())
        ->setEmail('ken@bc.com')
        ->setFirstName('Ken')
        ->setLastName('Ngo')
        ->setPostalCode('2166')
        ->setStateOrProvince('New South Wales')
        ->setStateOrProvinceCode('NSW')
        ->setCountryCode('AU')
        ->setCountry('Australia')
        ->setCity('Sydney')
        ->setAddressType('resident')
        ->setAddress2('U6')
        ->setAddress1('Longfield');
    $entityManager->save($newBillingAddress);

    /** create order for the checkout */
    $order = new \Bigcommerce\ORM\Entities\Order();
    $order->setCheckoutId($checkout->getId());
    $entityManager->create($order);
    echo "Order ID: {$order->getId()}" . PHP_EOL;

    /** find all transactions of order 156 */
    $transactions = $entityManager->findAll(\Bigcommerce\ORM\Entities\OrderTransaction::class, ['order_id' => $order->getId()], null, true);
    echo count($transactions). PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage();
}
