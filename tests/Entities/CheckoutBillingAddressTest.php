<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CheckoutBillingAddress;
use Tests\BaseTestCase;

class CheckoutBillingAddressTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CheckoutBillingAddress */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new CheckoutBillingAddress();
        $this->entity
            ->setCheckoutId(1)
            ->setEmail('kn@bc.com');

        $this->assertEquals(1, $this->entity->getCheckoutId());
        $this->assertEquals('kn@bc.com', $this->entity->getEmail());
    }
}