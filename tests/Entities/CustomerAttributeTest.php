<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CustomerAttribute;
use Tests\BaseTestCase;

class CustomerAttributeTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CustomerAttribute */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new CustomerAttribute();
        $this->entity
            ->setCustomerId(2)
            ->setName('name')
            ->setType('file')
            ->setId(1)
            ->setDateModified('2020-09-16')
            ->setDateCreated('2020-09-15');

        $this->assertEquals('name', $this->entity->getName());
        $this->assertEquals('file', $this->entity->getType());
        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getCustomerId());
        $this->assertEquals('2020-09-16', $this->entity->getDateModified());
        $this->assertEquals('2020-09-15', $this->entity->getDateCreated());
    }
}