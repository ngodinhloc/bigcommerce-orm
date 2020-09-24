<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\OrderRefundItem;
use Tests\BaseTestCase;

class OrderRefundItemTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\OrderRefundItem */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new OrderRefundItem();
        $this->entity
            ->setId(1)
            ->setOrderId(2)
            ->setQuantity(3)
            ->setAmount(10)
            ->setItemId(111)
            ->setItemType('physical')
            ->setReason('reason')
            ->setRequestedAmount(10);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getOrderId());
        $this->assertEquals(3, $this->entity->getQuantity());
        $this->assertEquals(10, $this->entity->getAmount());
        $this->assertEquals(111, $this->entity->getItemId());
        $this->assertEquals('physical', $this->entity->getItemType());
        $this->assertEquals('reason', $this->entity->getReason());
        $this->assertEquals(10, $this->entity->getRequestedAmount());
    }
}