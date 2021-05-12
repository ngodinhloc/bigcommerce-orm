<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\OrderRefundItem;
use Bigcommerce\ORM\Entities\OrderRefundQuote;
use Tests\BaseTestCase;

class OrderRefundQuoteTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\OrderRefundQuote */
    protected $entity;

    /**
     * testSettersAndGetters
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testSettersAndGetters()
    {
        $this->entity = new OrderRefundQuote();
        $this->entity
            ->setId(1)
            ->setOrderId(2)
            ->setItems([$this->getItem()])
            ->setTaxAdjustmentAmount(10);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getOrderId());
        $this->assertEquals([$this->getItem()], $this->entity->getItems());
        $this->assertEquals(10, $this->entity->getTaxAdjustmentAmount());
        $this->assertNull($this->entity->getRefundMethods());
        $this->assertNull($this->entity->getAdjustment());
        $this->assertNull($this->entity->getRounding());
        $this->assertNull($this->entity->getTotalRefundAmount());
        $this->assertNull($this->entity->getTotalRefundTaxAmount());
        $this->assertNull($this->entity->isTaxInclusive());

        $item = new OrderRefundItem();
        $item
            ->setOrderId(2)
            ->setItemType('digital')
            ->setItemId(111)
            ->setQuantity(2)
            ->setAmount(100);

        $this->entity->addRefundItem($item);
        $this->assertEquals(2, count($this->entity->getItems()));

    }

    private function getItem()
    {
        return [
            "item_type" => "HANDLING",
            "item_id" => 1,
            "reason" => "reason",
            "quantity" => 1,
            "requested_amount" => 0.05
        ];
    }
}
