<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\OrderTransaction;
use Tests\BaseTestCase;

class OrderTransactionTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\OrderTransaction */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new OrderTransaction();
        $this->entity
            ->setId(1)
            ->setOrderId(2)
            ->setOffline([])
            ->setAmount(10)
            ->setCurrency('USD')
            ->setDateCreated('2020-09-16')
            ->setStatus('approved')
            ->setAvsResult([])
            ->setCreditCard([])
            ->setCustom([])
            ->setCvvResult([])
            ->setEvent('none')
            ->setFraudReview(true)
            ->setGateway('paypal')
            ->setGatewayTransactionId('abc-def')
            ->setGiftCertificate([])
            ->setMethod('credit-cart')
            ->setPaymentInstrumentToken([])
            ->setPaymentMethodId('123-456')
            ->setReferenceTransactionId([])
            ->setStoreCredit([])
            ->setTest(true);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getOrderId());
        $this->assertEquals([], $this->entity->getOffline());
        $this->assertEquals(10, $this->entity->getAmount());
        $this->assertEquals('USD', $this->entity->getCurrency());
        $this->assertEquals('2020-09-16', $this->entity->getDateCreated());
        $this->assertEquals('approved', $this->entity->getStatus());
        $this->assertEquals([], $this->entity->getAvsResult());
        $this->assertEquals([], $this->entity->getCreditCard());
        $this->assertEquals([], $this->entity->getCustom());
        $this->assertEquals([], $this->entity->getCvvResult());
        $this->assertEquals('none', $this->entity->getEvent());
        $this->assertEquals(true, $this->entity->isFraudReview());
        $this->assertEquals('paypal', $this->entity->getGateway());
        $this->assertEquals('abc-def', $this->entity->getGatewayTransactionId());
        $this->assertEquals([], $this->entity->getGiftCertificate());
        $this->assertEquals('credit-cart', $this->entity->getMethod());
        $this->assertEquals([], $this->entity->getPaymentInstrumentToken());
        $this->assertEquals('123-456', $this->entity->getPaymentMethodId());
        $this->assertEquals([], $this->entity->getReferenceTransactionId());
        $this->assertEquals([], $this->entity->getStoreCredit());
        $this->assertEquals(true, $this->entity->isTest());
    }
}