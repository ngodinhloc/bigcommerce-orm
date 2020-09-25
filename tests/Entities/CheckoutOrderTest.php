<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CheckoutOrder;
use Tests\BaseTestCase;

class CheckoutOrderTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CheckoutOrder */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new CheckoutOrder();
        $this->entity
            ->setCheckoutId(2)
            ->setId(1);

        $this->assertEquals(2, $this->entity->getCheckoutId());
        $this->assertEquals(1, $this->entity->getId());
    }
}