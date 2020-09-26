<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {

    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** create cart with line items, custom items and gift certificates */
    $newCart = new \Bigcommerce\ORM\Entities\Cart();
    $newCart->setCustomerId(3);
    $lineItem1 = new \Bigcommerce\ORM\Entities\CartLineItem();
    $lineItem1
        ->setProductId(111)
        ->setQuantity(2);
    $lineItem2 = new \Bigcommerce\ORM\Entities\CartLineItem();
    $lineItem2
        ->setProductId(107)
        ->setQuantity(1);

    $giftCertificate = new \Bigcommerce\ORM\Entities\CartGiftCertificate();
    $giftCertificate
        ->setQuantity(1)
        ->setAmount(50)
        ->setName('Holiday Card')
        ->setTheme('Birthday')
        ->setMessage('Have a good holidays')
        ->setSender(['name' => 'Ken Ngo', 'email' => 'ken.ngo@bc.com'])
        ->setRecipient(['name' => 'Ken Ngo', 'email' => 'ken2.ngo@bc.com']);

    $customItem = new \Bigcommerce\ORM\Entities\CartCustomItem();
    $customItem
        ->setName('This is my item')
        ->setQuantity(1)
        ->setSku('sku')
        ->setListPrice(100);

    $newCart
        ->addLineItem($lineItem1)
        ->addLineItem($lineItem2)
        ->addGiftCertificate($giftCertificate)
        ->addCustomItem($customItem);

    $result = $entityManager->save($newCart);
    echo $newCart->getId();

    /** find one checkout cart id */
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
    echo count($coupons1);

    /**
     * Add new coupon to checkout
     * It seems that ene checkout can have ONLY ONE coupon, new coupon added will override old coupon
     */
    $newCoupon = new \Bigcommerce\ORM\Entities\CheckoutCoupon();
    $newCoupon
        ->setCheckoutId($checkout1->getId())
        ->setCode('80BBCB87B0C98AA');
    $entityManager->save($newCoupon);
    echo $newCoupon->getId();

    /** delete coupon */
    $result = $entityManager->delete($newCoupon, 'code');
    echo $result;

    /** Add new billing address */
    $newBillingAddress = new \Bigcommerce\ORM\Entities\CheckoutBillingAddress();
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
    echo $newBillingAddress->getId();

    /** check for coupon had been deleted and new shipping address added */
    $checkout2 = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, $newCart->getId(), null, true);
    /** @var \Bigcommerce\ORM\Entities\Checkout $checkout2 */
    $coupons2 = $checkout2->getCoupons();
    $billingAddress2 = $checkout2->getBillingAddress();
    echo count($coupons2);

    /** update billing address */
    $billingAddress2->setCity('Cabra');
    $entityManager->save($billingAddress2);
    echo $billingAddress2->getId();

    /** check for billing address updated */
    $checkout3 = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, $newCart->getId(), null, true);
    /** @var \Bigcommerce\ORM\Entities\Checkout $checkout3 */
    $billingAddress3 = $checkout2->getBillingAddress();
    echo $billingAddress3->getCity();

    /** create new consignments: consignment does not support save(), we have to use batchCreate */
    $newLineItem1 = $digitalItems1[0];
    $shippingAddress = $billingAddress3;
    $newConsignment1 = new \Bigcommerce\ORM\Entities\CheckoutConsignment();
    $newConsignment1
        ->setCheckoutId($checkout3->getId())
        ->addLineItem($newLineItem1)
        ->setShippingAddress($shippingAddress);

    $newConsignment2 = new \Bigcommerce\ORM\Entities\CheckoutConsignment();
    $newLineItem2 = $physicalItems1[0];
    $newCustomItem2 = $customItems1[0];
    $newConsignment2
        ->setCheckoutId($checkout3->getId())
        ->addLineItem($newLineItem2)
        ->setShippingAddress($shippingAddress);

    $result = $entityManager->batchCreate([$newConsignment1, $newConsignment2]);
    echo $result;

    /** check for new consignment added */
    $checkout4= $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, $checkout3->getId(), null, true);
    /** @var \Bigcommerce\ORM\Entities\Checkout $checkout4 */
    $consignments4 = $checkout4->getConsignments();
    echo count($consignments4);

    /** update consignment with shipping_option_id */
    $consignment4 = $consignments4[0];
    $availableShippingOptions = $consignment4->getAvailableShippingOptions();
    $shippingOption = $availableShippingOptions[0];

    $entityManager->update($consignment4, ['shipping_option_id' => $shippingOption->getId()]);
    echo $consignment4->getId();

    /** create order for the checkout */
    $checkoutOrder = new \Bigcommerce\ORM\Entities\CheckoutOrder();
    $checkoutOrder->setCheckoutId($checkout3->getId());
    $entityManager->create($checkoutOrder);
    echo $checkoutOrder->getId();

    /** get payment access token for order */
    $paymentAccessToken = new \Bigcommerce\ORM\Entities\PaymentAccessToken();
    $paymentAccessToken->setCheckoutOrder($checkoutOrder);
    $entityManager->create($paymentAccessToken);
    echo $paymentAccessToken->getId();

    /** get accepted payment methods for this order */
    $queryBuilder = new \Bigcommerce\ORM\QueryBuilder();
    $queryBuilder->whereEqual('order_id', $checkoutOrder->getId());
    $paymentMethods = $entityManager->findBy(\Bigcommerce\ORM\Entities\PaymentMethod::class, ['order_id' => $checkoutOrder->getId()], $queryBuilder, false);
    echo count($paymentMethods);

    /** made payment for this order */
    $card = new \Bigcommerce\ORM\Entities\Card();
    $card
        ->setType('card')
        ->setCardholderName('Ken Ngo')
        ->setNumber('4111111111111111')
        ->setExpiryMonth(2)
        ->setExpiryYear(2021)
        ->setVerificationValue('111');
    $payment = new \Bigcommerce\ORM\Entities\Payment();
    $paymentMethod = $paymentMethods[0];
    $payment
        ->setPaymentMethod($paymentMethod)
        ->setPaymentInstrument($card)
        ->setAmount(134)
        ->setCurrencyCode('USD');
    /** in order to process payment, we need to set EntityManager payment access token */
    $entityManager->setPaymentAccessToken($paymentAccessToken);
    $entityManager->create($payment);
    echo $payment->getId();
} catch (\Exception $e) {
    echo $e->getMessage();
}
