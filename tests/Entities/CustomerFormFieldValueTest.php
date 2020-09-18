<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CustomerFormFieldValue;
use Tests\BaseTestCase;

class CustomerFormFieldValueTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CustomerFormFieldValue */
    protected $value;

    public function testSettersAndGetters()
    {
        $this->value = new CustomerFormFieldValue();
        $this->value
            ->setCustomerId(1)
            ->setId(2)
            ->setName('age')
            ->setValue(30);

        $this->assertEquals(1, $this->value->getCustomerId());
        $this->assertEquals(2, $this->value->getId());
        $this->assertEquals('age', $this->value->getName());
        $this->assertEquals(30, $this->value->getValue());
    }
}