<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {

    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** find one cart by id = e9e687cd-6711-4a93-99a1-b7d5aa5ad122 */
    $cart = $entityManager->find(\Bigcommerce\ORM\Entities\Cart::class, 'e9e687cd-6711-4a93-99a1-b7d5aa5ad122', null, true);
    /** @var \Bigcommerce\ORM\Entities\Cart $cart */
    $digitalItems = $cart->getDigitalLineItems();
    $physicalItems = $cart->getPhysicalLineItems();
    $customItems = $cart->getCustomItems();
    $gifs = $cart->getGiftCertificates();
    $coupons = $cart->getCoupons();

    /** update cart will only change customer_id */
    $cart->setCustomerId(3);
    $result = $entityManager->save($cart);
    echo $result;

    $newCart = new \Bigcommerce\ORM\Entities\Cart();
    $newCart->setCustomerId(3);
    $item1 = new \Bigcommerce\ORM\Entities\CartLineItem();
    $item1
        ->setProductId(111)
        ->setQuantity(2);
    $item2 = new \Bigcommerce\ORM\Entities\CartLineItem();
    $item2
        ->setProductId(107)
        ->setQuantity(5);

    $gift = new \Bigcommerce\ORM\Entities\CartGiftCertificate();
    $gift
        ->setQuantity(1)
        ->setAmount(50)
        ->setName('Holiday Card')
        ->setTheme('Birthday')
        ->setMessage('Have a good holidays')
        ->setSender(['name' => 'Ken Ngo', 'email' => 'ken.ngo@bc.com'])
        ->setRecipient(['name' => 'Ken Ngo', 'email' => 'ken2.ngo@bc.com']);

    $custom = new \Bigcommerce\ORM\Entities\CartCustomItem();
    $custom
        ->setName('This is my item')
        ->setQuantity(1)
        ->setSku('sku')
        ->setListPrice(100);

    $newCart
        ->addLineItem($item1)
        ->addLineItem($item2)
        ->addGiftCertificate($gift)
        ->addCustomItem($custom);

    $result = $entityManager->save($newCart);
    $newPhysicalItems = $newCart->getPhysicalLineItems();
    $newDigitalItems = $newCart->getDigitalLineItems();
    $newCustomItems = $newCart->getCustomItems();
    $newGifts = $newCart->getGiftCertificates();
    echo $result;
} catch (\Exception $e) {
    echo $e->getMessage();
}
