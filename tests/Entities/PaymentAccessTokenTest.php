<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CheckoutOrder;
use Bigcommerce\ORM\Entities\PaymentAccessToken;
use Tests\BaseTestCase;

class PaymentAccessTokenTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\PaymentAccessToken */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new PaymentAccessToken();
        $this->entity
            ->setId('123')
            ->setOrder([]);

        $this->assertEquals('123', $this->entity->getId());
        $this->assertEquals([], $this->entity->getOrder());

        $order = new CheckoutOrder();
        $order
            ->setId('abc-def')
            ->setIsRecurring(true);
        $this->entity->setCheckoutOrder($order);
        $this->assertEquals(['id' => 'abc-def', 'is_recurring' => true], $this->entity->getOrder());
    }
}