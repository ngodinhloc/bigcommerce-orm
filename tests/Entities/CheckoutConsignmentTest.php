<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CartLineItem;
use Bigcommerce\ORM\Entities\CheckoutConsignment;
use Bigcommerce\ORM\Entities\CheckoutConsignmentShippingAddress;
use Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption;
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
            ->setCheckoutId(2)
            ->setCouponDiscounts([])
            ->setDiscounts([])
            ->setLineItemIds([])
            ->setSelectedShippingOption(null)
            ->setCheckoutShippingAddress(null);

        $this->assertEquals(100, $this->entity->getShippingCostTotalExTax());
        $this->assertEquals(110, $this->entity->getShippingCostTotalIncTax());
        $this->assertEquals(11, $this->entity->getHandlingCostTotalIncTax());
        $this->assertEquals(10, $this->entity->getHandlingCostTotalExTax());
        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getCheckoutId());
        $this->assertEquals([], $this->entity->getCouponDiscounts());
        $this->assertEquals([], $this->entity->getDiscounts());
        $this->assertEquals([], $this->entity->getLineItemIds());
        $this->assertEquals(null, $this->entity->getSelectedShippingOption());
        $this->assertEquals(null, $this->entity->getCheckoutShippingAddress());
        $this->assertEquals(null, $this->entity->getAvailableShippingOptions());

        $lineItem = new CartLineItem();
        $lineItem
            ->setId(1)
            ->setQuantity(2);
        $this->entity->addLineItem($lineItem);
        $this->assertEquals([['item_id' => 1, 'quantity' => 2]], $this->entity->getLineItems());

        $shippingAddress = new CheckoutConsignmentShippingAddress();
        $shippingAddress->setCity('Sydney');
        $this->entity->setShippingAddress($shippingAddress);
        $address = $this->entity->getShippingAddress();
        $this->assertIsArray($address);

        $shippingOption = new CheckoutConsignmentShippingOption();
        $shippingOption->setId(1);
        $this->entity->setShippingOption($shippingOption);
        $this->assertEquals(1, $this->entity->getShippingOptionId());
    }
}