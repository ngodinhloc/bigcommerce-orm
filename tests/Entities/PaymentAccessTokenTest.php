<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Order;
use Bigcommerce\ORM\Entities\PaymentAccessToken;
use Tests\BaseTestCase;

class PaymentAccessTokenTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\PaymentAccessToken */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new PaymentAccessToken();
        $this->entity
            ->setId('123')
            ->setOrderValue([]);

        $this->assertEquals('123', $this->entity->getId());
        $this->assertEquals([], $this->entity->getOrderValue());

        $order = new Order();
        $order
            ->setId('abc-def')
            ->setIsRecurring(true);
        $this->entity->setOrder($order);
        $this->assertEquals(['id' => 'abc-def', 'is_recurring' => true], $this->entity->getOrderValue());
    }
}
