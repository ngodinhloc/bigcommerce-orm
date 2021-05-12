<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CustomerFormFieldValue;
use Tests\BaseTestCase;

class CustomerFormFieldValueTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\CustomerFormFieldValue */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new CustomerFormFieldValue();
        $this->entity
            ->setCustomerId(1)
            ->setAddressId(3)
            ->setId(2)
            ->setName('age')
            ->setValue(30);

        $this->assertEquals(1, $this->entity->getCustomerId());
        $this->assertEquals(2, $this->entity->getId());
        $this->assertEquals('age', $this->entity->getName());
        $this->assertEquals(30, $this->entity->getValue());
        $this->assertEquals(3, $this->entity->getAddressId());
    }
}
