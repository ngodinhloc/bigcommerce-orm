<?php

require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');
$customerId = 1;
$digitalProductId = 111;
$physicalProductId = 107;
$couponCode = 'C2CD2B567A7D409';

try {
    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** create cart with one digital line item */
    $newCart = new \Bigcommerce\ORM\Entities\Cart();
    $newCart->setCustomerId($customerId);

    $lineItem1 = new \Bigcommerce\ORM\Entities\LineItem();
    $lineItem1
        ->setProductId(111)
        ->setQuantity(1);

    $newCart->addLineItem($lineItem1);
    $result = $entityManager->save($newCart);
    echo "Created Cart ID: {$newCart->getId()}" . PHP_EOL;
    echo "Line Item Count:" . count($newCart->getLineItems()) . PHP_EOL;

    /** add more items to cart: line item, gift certificate, custom item */
    $lineItem2 = new \Bigcommerce\ORM\Entities\LineItem();
    $lineItem2
        ->setProductId(107)
        ->setQuantity(1);

    /** gift certificate  */
    $giftCertificate = new \Bigcommerce\ORM\Entities\GiftCertificate();
    $giftCertificate
        ->setQuantity(1)
        ->setAmount(50)
        ->setName('Holiday Card')
        ->setTheme('Birthday')
        ->setMessage('Have a good holidays')
        ->setSender(['name' => 'Ken Ngo', 'email' => 'ken.ngo@bc.com'])
        ->setRecipient(['name' => 'Ken Ngo', 'email' => 'ken2.ngo@bc.com']);

    /** custom item */
    $customItem = new \Bigcommerce\ORM\Entities\CustomItem();
    $customItem
        ->setName('This is my item')
        ->setQuantity(1)
        ->setSku('sku')
        ->setListPrice(100);

    $cartItem = new \Bigcommerce\ORM\Entities\CartItem();
    $cartItem
        ->setCartId($newCart->getId())
        ->addLineItem($lineItem2)
        ->addGiftCertificate($giftCertificate)
        ->addCustomItem($customItem);
    $entityManager->save($cartItem);
    echo "Added Custom Item ID: {$cartItem->getId()}" . PHP_EOL;

    /** find checkout of the created cart */
    $checkout1 = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, $newCart->getId(), null, true);
    /** @var \Bigcommerce\ORM\Entities\Checkout $checkout1 */
    $billingAddress1 = $checkout1->getBillingAddress();
    $consignments1 = $checkout1->getConsignments();
    $coupons1 = $checkout1->getCoupons();
    $cart1 = $checkout1->getCart();
    $digitalItems1 = $cart1->getDigitalItems();
    $physicalItems1 = $cart1->getPhysicalItems();
    $giftCertificates1 = $cart1->getGiftCertificates();
    $customItems1 = $cart1->getCustomItems();
    echo "Cart Coupon Count: " . count($coupons1) . PHP_EOL;
    echo "Digital Item Count: " . count($digitalItems1) . PHP_EOL;
    echo "Physical Item Count: " . count($physicalItems1) . PHP_EOL;
    echo "Gift Certificate Count: " . count($giftCertificates1) . PHP_EOL;
    echo "Custom Item Count: " . count($customItems1) . PHP_EOL;

    /**
     * Add coupon to checkout
     * It seems that one checkout can have ONLY ONE coupon, new coupon added will override old coupon
     */
    $newCoupon = new \Bigcommerce\ORM\Entities\Coupon();
    $newCoupon
        ->setCheckoutId($checkout1->getId())
        ->setCode($couponCode);
    $entityManager->save($newCoupon);
    echo "Added Coupon ID: {$newCoupon->getId()}" . PHP_EOL;

    /** check for coupon added */
    $checkout2 = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, $newCart->getId(), null, true);
    /** @var \Bigcommerce\ORM\Entities\Checkout $checkout2 */
    $coupons2 = $checkout2->getCoupons();
    echo "Coupon Count:" . count($coupons2) . PHP_EOL;

    /** Add billing address */
    $newBillingAddress = new \Bigcommerce\ORM\Entities\BillingAddress();
    $newBillingAddress
        ->setCheckoutId($checkout1->getId())
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

    /** check for billing address added */
    $checkout2 = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, $newCart->getId(), null, true);
    /** @var \Bigcommerce\ORM\Entities\Checkout $checkout2 */
    $billingAddress2 = $checkout2->getBillingAddress();
    echo "Added Billing Address ID: {$billingAddress2->getId()}" . PHP_EOL;

    /** create new consignments: consignment does not support save(), we have to use batchCreate */
    $newLineItem1 = current($digitalItems1);
    $shippingAddress = $billingAddress2;
    $newConsignment1 = new \Bigcommerce\ORM\Entities\Consignment();
    $newConsignment1
        ->setCheckoutId($checkout2->getId())
        ->addLineItem($newLineItem1)
        ->setShippingAddress($shippingAddress);

    $newConsignment2 = new \Bigcommerce\ORM\Entities\Consignment();
    $newLineItem2 = current($physicalItems1);
    $newCustomItem2 = current($customItems1);
    $newConsignment2
        ->setCheckoutId($checkout2->getId())
        ->addLineItem($newLineItem2)
        ->setShippingAddress($shippingAddress);

    $result = $entityManager->batchCreate([$newConsignment1, $newConsignment2]);
    echo "Consignment Creating Result: {$result}" . PHP_EOL;

    /** check for new consignment added */
    $checkout4 = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, $checkout2->getId(), null, true);
    /** @var \Bigcommerce\ORM\Entities\Checkout $checkout4 */
    $consignments4 = $checkout4->getConsignments();
    echo "Consignment Count: " . count($consignments4) . PHP_EOL;

    /** update consignment with shipping_option_id */
    $consignment4 = current($consignments4);
    $availableShippingOptions = $consignment4->getAvailableShippingOptions();
    $shippingOption = current($availableShippingOptions);

    /** Because shipping option can not be updated along with shipping address and line items */
//    $consignment4->setShippingOption($shippingOption);
//    $entityManager->save($consignment4);

    /** We have to update consignment shipping_option_id using update() */
    $entityManager->update($consignment4, ['shipping_option_id' => $shippingOption->getId()]);
    echo "Shipping Option ID: {$shippingOption->getId()}" . PHP_EOL;

    echo "Checkout ID: {$checkout2->getId()}" . PHP_EOL;

    /** create order for the checkout */
    $order = new \Bigcommerce\ORM\Entities\Order();
    $order->setCheckoutId($checkout2->getId());
    $entityManager->create($order);
    echo "Order ID: {$order->getId()}" . PHP_EOL;

    /** create payment access token for this order */
    $paymentAccessToken = new \Bigcommerce\ORM\Entities\PaymentAccessToken();
    $paymentAccessToken->setOrder($order);
    $entityManager->create($paymentAccessToken);
    echo "Payment Access Token: {$paymentAccessToken->getId()}" . PHP_EOL;

    /** get accepted payment methods for this order */
    $queryBuilder = new \Bigcommerce\ORM\QueryBuilder();
    $queryBuilder->whereEqual('order_id', $order->getId());
    $paymentMethods = $entityManager->findBy(
        \Bigcommerce\ORM\Entities\PaymentMethod::class,
        null,
        $queryBuilder,
        false
    );
    echo "Payment Method Count: " . count($paymentMethods) . PHP_EOL;

    /** @var \Bigcommerce\ORM\Entities\PaymentMethod $paymentMethod */
    $paymentMethod = current($paymentMethods);
    echo "Select Payment Method: {$paymentMethod->getName()}" . PHP_EOL;

    /** made payment for this order */
    $card = new \Bigcommerce\ORM\Entities\Card();
    $card
        ->setType('card')
        ->setCardholderName('Ken Ngo')
        ->setNumber('4111111111111111')
        ->setExpiryMonth(2)
        ->setExpiryYear(2022)
        ->setVerificationValue('111');

    $payment = new \Bigcommerce\ORM\Entities\Payment();
    $payment
        ->setPaymentAccessToken($paymentAccessToken)
        ->setPaymentMethod($paymentMethod)
        ->setPaymentInstrument($card)
        ->setAmount(134)
        ->setCurrencyCode('USD');
    $entityManager->create($payment);
    echo "Payment ID: {$payment->getId()}".PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage();
}
