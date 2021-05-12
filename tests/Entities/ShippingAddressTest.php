<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ShippingAddress;
use Tests\BaseTestCase;

class ShippingAddressTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\ShippingAddress */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new ShippingAddress();
        $this->entity->setEmail('kn@bc.com');
        $this->assertEquals('kn@bc.com', $this->entity->getEmail());
    }
}
