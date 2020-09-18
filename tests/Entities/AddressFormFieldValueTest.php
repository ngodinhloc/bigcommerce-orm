<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\AddressFormFieldValue;
use Tests\BaseTestCase;

class AddressFormFieldValueTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\AddressFormFieldValue */
    protected $value;

    public function testSettersAndGetters()
    {
        $this->value = new AddressFormFieldValue();
        $this->value
            ->setValue(112)
            ->setId(1)
            ->setName('street_number')
            ->setAddressId(2);

        $this->assertEquals(112, $this->value->getValue());
        $this->assertEquals(1, $this->value->getId());
        $this->assertEquals('street_number', $this->value->getName());
        $this->assertEquals(2, $this->value->getAddressId());
    }
}