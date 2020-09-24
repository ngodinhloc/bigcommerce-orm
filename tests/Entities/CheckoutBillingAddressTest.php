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
        $this->entity->setEmail('kn@bc.com');
        $this->assertEquals('kn@bc.com', $this->entity->getEmail());
    }
}