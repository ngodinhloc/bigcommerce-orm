<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CustomerAttributeValue;
use Tests\BaseTestCase;

class CustomerAttributeValueTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CustomerAttributeValue */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new CustomerAttributeValue();
        $this->entity
            ->setDateCreated('2020-09-16')
            ->setDateModified('2020-09-17')
            ->setId(1)
            ->setCustomerId(2)
            ->setAttributeId(3)
            ->setAttributeValue('value');
        $this->assertEquals('2020-09-16', $this->entity->getDateCreated());
        $this->assertEquals('2020-09-17', $this->entity->getDateModified());
        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(3, $this->entity->getAttributeId());
        $this->assertEquals(2, $this->entity->getCustomerId());
        $this->assertEquals('value', $this->entity->getAttributeValue());
    }
}