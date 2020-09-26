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
    $digitalItems = $cart->getDigitalItems();
    $physicalItems = $cart->getPhysicalItems();
    $customItems = $cart->getCustomItems();
    $gifsCertificates = $cart->getGiftCertificates();
    $coupons = $cart->getCoupons();
    $redirectUrl = $cart->getRedirectUrl();
    echo $redirectUrl->getCartUrl();

    /** update cart will only change customer_id */
    $cart->setCustomerId(3);
    $result = $entityManager->save($cart);
    echo $result;

    /** create cart with line items, custom items and gift certificates */
    $newCart = new \Bigcommerce\ORM\Entities\Cart();
    $newCart->setCustomerId(3);
    $lineItem1 = new \Bigcommerce\ORM\Entities\LineItem();
    $lineItem1
        ->setProductId(111)
        ->setQuantity(2);
    $lineItem2 = new \Bigcommerce\ORM\Entities\LineItem();
    $lineItem2
        ->setProductId(107)
        ->setQuantity(5);

    $giftCertificate = new \Bigcommerce\ORM\Entities\GiftCertificate();
    $giftCertificate
        ->setQuantity(1)
        ->setAmount(50)
        ->setName('Holiday Card')
        ->setTheme('Birthday')
        ->setMessage('Have a good holidays')
        ->setSender(['name' => 'Ken Ngo', 'email' => 'ken.ngo@bc.com'])
        ->setRecipient(['name' => 'Ken Ngo', 'email' => 'ken2.ngo@bc.com']);

    $customItem = new \Bigcommerce\ORM\Entities\CustomItem();
    $customItem
        ->setName('This is my item')
        ->setQuantity(1)
        ->setSku('sku')
        ->setListPrice(100);

    $newCart
        ->addLineItem($lineItem1)
        ->addGiftCertificate($giftCertificate)
        ->addCustomItem($customItem);

    $result = $entityManager->save($newCart);
    $physicalItems1 = $newCart->getPhysicalItems();
    $digitalItems1 = $newCart->getDigitalItems();
    $customItems1 = $newCart->getCustomItems();
    $giftCertificates1 = $newCart->getGiftCertificates();
    echo $result;

    /** create redirect url for cart */
    $newUrl = new \Bigcommerce\ORM\Entities\CartRedirectUrl();
    $newUrl->setCartId($newCart->getId());
    $entityManager->save($newUrl);
    echo $newUrl->getCartUrl();

    /** add more items to cart after creating by using CartItem */
    $cartItem = new \Bigcommerce\ORM\Entities\CartItem();
    $cartItem
        ->setCartId($newCart->getId())
        ->addLineItem($lineItem2)
        ->addGiftCertificate($giftCertificate)
        ->addCustomItem($customItem);
    $entityManager->save($cartItem);

    $updatedCart = $entityManager->find(\Bigcommerce\ORM\Entities\Cart::class, $newCart->getId(), null, true);
    /** @var \Bigcommerce\ORM\Entities\Cart $updatedCart */
    $digitalItems2 = $updatedCart->getDigitalItems();
    $physicalItems2 = $updatedCart->getPhysicalItems();
    $customItems2 = $updatedCart->getCustomItems();
    $gifsCertificates2 = $updatedCart->getGiftCertificates();
    echo $updatedCart->getId();

} catch (\Exception $e) {
    echo $e->getMessage();
}
