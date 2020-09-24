<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CheckoutConsignmentShippingAddress;
use Tests\BaseTestCase;

class CheckoutConsignmentShippingAddressTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingAddress */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new CheckoutConsignmentShippingAddress();
        $this->entity->setEmail('kn@bc.com');
        $this->assertEquals('kn@bc.com', $this->entity->getEmail());
    }
}