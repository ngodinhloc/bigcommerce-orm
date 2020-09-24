<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Checkout;
use Tests\BaseTestCase;

class CheckoutTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\Checkout */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new Checkout();
        $this->entity
            ->setId(1)
            ->setUpdatedTime('2020-09-17')
            ->setCreatedTime('2020-09-16')
            ->setCoupons([])
            ->setCustomerMessage('message')
            ->setGrandTotal(1000)
            ->setHandlingCostTotalExTax(10)
            ->setHandlingCostTotalIncTax(11)
            ->setOrderId('abc-def')
            ->setShippingCostTotalExTax(100)
            ->setShippingCostTotalIncTax(110)
            ->setSubtotalExTax(800)
            ->setSubtotalIncTax(880)
            ->setTaxTotal(20)
            ->setTaxes([])
            ->setCoupons([])
            ->setCart(null)
            ->setBillingAddress(null)
            ->setConsignments([]);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('2020-09-17', $this->entity->getUpdatedTime());
        $this->assertEquals('2020-09-16', $this->entity->getCreatedTime());
        $this->assertEquals([], $this->entity->getCoupons());
        $this->assertEquals('message', $this->entity->getCustomerMessage());
        $this->assertEquals(1000, $this->entity->getGrandTotal());
        $this->assertEquals(10, $this->entity->getHandlingCostTotalExTax());
        $this->assertEquals(11, $this->entity->getHandlingCostTotalIncTax());
        $this->assertEquals('abc-def', $this->entity->getOrderId());
        $this->assertEquals(100, $this->entity->getShippingCostTotalExTax());
        $this->assertEquals(110, $this->entity->getShippingCostTotalIncTax());
        $this->assertEquals(800, $this->entity->getSubtotalExTax());
        $this->assertEquals(880, $this->entity->getSubtotalIncTax());
        $this->assertEquals(20, $this->entity->getTaxTotal());
        $this->assertEquals([], $this->entity->getTaxes());
        $this->assertEquals([], $this->entity->getCoupons());
        $this->assertEquals(null, $this->entity->getCart());
        $this->assertEquals(null, $this->entity->getBillingAddress());
        $this->assertEquals([], $this->entity->getConsignments());
    }
}