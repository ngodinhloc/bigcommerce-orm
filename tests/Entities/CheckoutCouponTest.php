<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CheckoutCoupon;
use Tests\BaseTestCase;

class CheckoutCouponTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CheckoutCoupon */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new CheckoutCoupon();
        $this->entity
            ->setCheckoutId(2)
            ->setId(1)
            ->setName('name')
            ->setCode('code')
            ->setDiscountAmount(10)
            ->setType('type');

        $this->assertEquals(2, $this->entity->getCheckoutId());
        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('name', $this->entity->getName());
        $this->assertEquals('code', $this->entity->getCode());
        $this->assertEquals(10, $this->entity->getDiscountAmount());
        $this->assertEquals('type', $this->entity->getType());
    }
}