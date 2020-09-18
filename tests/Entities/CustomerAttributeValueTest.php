<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CustomerAttributeValue;
use Tests\BaseTestCase;

class CustomerAttributeValueTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CustomerAttributeValue */
    protected $value;

    public function testSettersAndGetters()
    {
        $this->value = new CustomerAttributeValue();
        $this->value
            ->setDateCreated('2020-09-16')
            ->setDateModified('2020-09-17')
            ->setId(1)
            ->setCustomerId(2)
            ->setAttributeId(3)
            ->setAttributeValue('value');
        $this->assertEquals('2020-09-16', $this->value->getDateCreated());
        $this->assertEquals('2020-09-17', $this->value->getDateModified());
        $this->assertEquals(1, $this->value->getId());
        $this->assertEquals(3, $this->value->getAttributeId());
        $this->assertEquals(2, $this->value->getCustomerId());
        $this->assertEquals('value', $this->value->getAttributeValue());
    }
}