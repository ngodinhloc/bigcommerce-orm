<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\PaymentMethod;
use Tests\BaseTestCase;

class PaymentMethodTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\PaymentMethod */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new PaymentMethod();
        $this->entity
            ->setId(1)
            ->setOrderId(2)
            ->setType('api')
            ->setName('name')
            ->setStoreInstruments([])
            ->setSupportedInstruments([])
            ->setTestMode(true);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getOrderId());
        $this->assertEquals('api', $this->entity->getType());
        $this->assertEquals('name', $this->entity->getName());
        $this->assertEquals(true, $this->entity->isTestMode());
        $this->assertEquals([], $this->entity->getStoreInstruments());
        $this->assertEquals([], $this->entity->getSupportedInstruments());
    }
}