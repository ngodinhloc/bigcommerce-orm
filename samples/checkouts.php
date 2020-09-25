<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {

    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** find one checkout by id = e9e687cd-6711-4a93-99a1-b7d5aa5ad122 */
    $checkout1 = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, 'e9e687cd-6711-4a93-99a1-b7d5aa5ad122', null, true);
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
        ->setState('NSW')
        ->setCountryCode('AUS')
        ->setCountry('Australia')
        ->setCity('Sydney')
        ->setAddressType('resident')
        ->setAddress2('U6')
        ->setAddress1('Longfield');
    $entityManager->save($newBillingAddress);
    $newBillingAddress->getId();

    /** check for coupon had been deleted and new shipping address added */
    $checkout2 = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, 'e9e687cd-6711-4a93-99a1-b7d5aa5ad122', null, true);
    /** @var \Bigcommerce\ORM\Entities\Checkout $checkout2 */
    $coupons2 = $checkout2->getCoupons();
    $billingAddress2 = $checkout2->getBillingAddress();
    echo count($coupons2);

    /** update billing address */
    $billingAddress2->setCity('Cabra');
    $entityManager->save($billingAddress2);
    echo $billingAddress2->getId();

    /** check fore billing address updated */
    $checkout3 = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, 'e9e687cd-6711-4a93-99a1-b7d5aa5ad122', null, true);
    /** @var \Bigcommerce\ORM\Entities\Checkout $checkout3 */
    $billingAddress3 = $checkout2->getBillingAddress();
    echo $billingAddress3->getCity();

    /** create check out order */
    $checkoutOrder = new \Bigcommerce\ORM\Entities\CheckoutOrder();
    $checkoutOrder->setCheckoutId($checkout3->getId());
    $entityManager->save($checkoutOrder);
    echo $checkoutOrder->getId();

    /** create new consignment: consignment does not support save(), we have to use batchCreate */
    $newLineItem = $digitalItems1[0];
    $shippingAddress = $consignments1[0]->getCheckoutShippingAddress();
    $newConsignment = new \Bigcommerce\ORM\Entities\CheckoutConsignment();
    $newConsignment
        ->setCheckoutId($checkout3->getId())
        ->addLineItem($newLineItem)
        ->setShippingAddress($shippingAddress);
    $result = $entityManager->batchCreate([$newConsignment]);
    echo $result;

} catch (\Exception $e) {
    echo $e->getMessage();
}
