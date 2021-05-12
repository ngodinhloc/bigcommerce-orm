<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\OrderRefundPayment;
use Tests\BaseTestCase;

class OrderRefundPaymentTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\OrderRefundPayment */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new OrderRefundPayment();
        $this->entity
            ->setId(1)
            ->setOrderId(2)
            ->setAmount(10)
            ->setDeclinedMessage('declined')
            ->setIsDeclined(true)
            ->setOffline(false)
            ->setProviderId('paypal');

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getOrderId());
        $this->assertEquals(10, $this->entity->getAmount());
        $this->assertEquals('declined', $this->entity->getDeclinedMessage());
        $this->assertEquals(true, $this->entity->isDeclined());
        $this->assertEquals(false, $this->entity->isOffline());
        $this->assertEquals('paypal', $this->entity->getProviderId());
    }
}
