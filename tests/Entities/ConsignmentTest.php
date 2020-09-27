<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Consignment;
use Bigcommerce\ORM\Entities\LineItem;
use Bigcommerce\ORM\Entities\ShippingAddress;
use Bigcommerce\ORM\Entities\ShippingOption;
use Tests\BaseTestCase;

class ConsignmentTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\Consignment */
    protected $entity;

    /**
     * testSettersAndGetters
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testSettersAndGetters()
    {
        $this->entity = new Consignment();
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
            ->setShippingOptionId(1)
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
        $this->assertEquals(1, $this->entity->getShippingOptionId());
        $this->assertEquals(null, $this->entity->getSelectedShippingOption());
        $this->assertEquals(null, $this->entity->getCheckoutShippingAddress());
        $this->assertEquals(null, $this->entity->getAvailableShippingOptions());

        $lineItem = new LineItem();
        $lineItem
            ->setId(1)
            ->setQuantity(2);
        $this->entity->addLineItem($lineItem);
        $this->assertEquals([['item_id' => 1, 'quantity' => 2]], $this->entity->getLineItems());

        $shippingAddress = new ShippingAddress();
        $shippingAddress->setCity('Sydney');
        $this->entity->setShippingAddress($shippingAddress);
        $address = $this->entity->getShippingAddress();
        $this->assertIsArray($address);

        $shippingOption = new ShippingOption();
        $shippingOption->setId(2);
        $this->entity->setShippingOption($shippingOption);
        $this->assertEquals(2, $this->entity->getShippingOptionId());
    }
}