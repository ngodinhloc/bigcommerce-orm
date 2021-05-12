<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\BillingAddress;
use Tests\BaseTestCase;

class BillingAddressTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\BillingAddress */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new BillingAddress();
        $this->entity
            ->setCheckoutId(1)
            ->setEmail('kn@bc.com');

        $this->assertEquals(1, $this->entity->getCheckoutId());
        $this->assertEquals('kn@bc.com', $this->entity->getEmail());
    }
}
