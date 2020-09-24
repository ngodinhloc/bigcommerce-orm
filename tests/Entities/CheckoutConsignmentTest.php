<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CheckoutConsignment;
use Tests\BaseTestCase;

class CheckoutConsignmentTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CheckoutConsignment */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new CheckoutConsignment();
        $this->entity
            ->setShippingCostTotalExTax(100)
            ->setShippingCostTotalIncTax(110)
            ->setHandlingCostTotalIncTax(11)
            ->setHandlingCostTotalExTax(10)
            ->setId(1)
            ->setCouponDiscounts([])
            ->setDiscounts([])
            ->setLineItemIds([])
            ->setSelectedShippingOption(null)
            ->setShippingAddress(null);

        $this->assertEquals(100, $this->entity->getShippingCostTotalExTax());
        $this->assertEquals(110, $this->entity->getShippingCostTotalIncTax());
        $this->assertEquals(11, $this->entity->getHandlingCostTotalIncTax());
        $this->assertEquals(10, $this->entity->getHandlingCostTotalExTax());
        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals([], $this->entity->getCouponDiscounts());
        $this->assertEquals([], $this->entity->getDiscounts());
        $this->assertEquals([], $this->entity->getLineItemIds());
        $this->assertEquals(null, $this->entity->getSelectedShippingOption());
        $this->assertEquals(null, $this->entity->getShippingAddress());
    }
}