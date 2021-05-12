<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\OrderRefund;
use Bigcommerce\ORM\Entities\OrderRefundItem;
use Bigcommerce\ORM\Entities\OrderRefundPayment;
use Tests\BaseTestCase;

class OrderRefundTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\OrderRefund */
    protected $entity;

    /**
     * testSettersAndGetters
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testSettersAndGetters()
    {
        $this->entity = new OrderRefund();

        $this->assertNull($this->entity->getRefundItems());
        $this->assertNull($this->entity->getRefundPayments());
        $this->entity
            ->setId(1)
            ->setOrderId(2)
            ->setTaxAdjustmentAmount(1.5)
            ->setItems([$this->getItem()])
            ->setPayments([$this->getPayment()]);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getOrderId());
        $this->assertEquals(1.5, $this->entity->getTaxAdjustmentAmount());
        $this->assertEquals([$this->getItem()], $this->entity->getItems());
        $this->assertEquals([$this->getPayment()], $this->entity->getPayments());
        $this->assertNull($this->entity->getUserId());
        $this->assertNull($this->entity->getCreated());
        $this->assertNull($this->entity->getReason());
        $this->assertNull($this->entity->getTotalAmount());
        $this->assertNull($this->entity->getTotalTax());

        $refundItems = $this->entity->getRefundItems();
        $refundPayments = $this->entity->getRefundPayments();
        $this->assertEquals(1, count($refundItems));
        $this->assertEquals(1, count($refundPayments));
        $refundItem = $refundItems[0];
        $refundPayment = $refundPayments[0];
        $this->assertInstanceOf(OrderRefundItem::class, $refundItem);
        $this->assertInstanceOf(OrderRefundPayment::class, $refundPayment);

        $this->entity
            ->addRefundItem($refundItem)
            ->addRefundPayment($refundPayment);

        $this->assertEquals(2, count($this->entity->getItems()));
        $this->assertEquals(2, count($this->entity->getPayments()));
    }

    private function getPayment()
    {
        return [
            "id" => 1,
            "provider_id" => "checkout_paypalexpress",
            "amount" => 1.99,
            "offline" => true,
            "is_declined" => true,
            "declined_message" => 'declined'
        ];
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
