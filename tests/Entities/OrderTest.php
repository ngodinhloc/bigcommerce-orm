<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Order;
use Tests\BaseTestCase;

class OrderTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\Order */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new Order();
        $this->entity
            ->setCheckoutId(2)
            ->setIsRecurring(false)
            ->setId(1);

        $this->assertEquals(2, $this->entity->getCheckoutId());
        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(false, $this->entity->isRecurring());
    }
}