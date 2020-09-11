<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Address;
use Tests\BaseTestCase;

class AddressTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\Address */
    protected $address;

    /**
     * @covers \Bigcommerce\ORM\Entities\Address::setId
     * @covers \Bigcommerce\ORM\Entities\Address::setAddress1
     * @covers \Bigcommerce\ORM\Entities\Address::setAddress2
     * @covers \Bigcommerce\ORM\Entities\Address::setAddressType
     * @covers \Bigcommerce\ORM\Entities\Address::setCity
     * @covers \Bigcommerce\ORM\Entities\Address::setCompany
     * @covers \Bigcommerce\ORM\Entities\Address::setCountry
     * @covers \Bigcommerce\ORM\Entities\Address::setCountryCode
     * @covers \Bigcommerce\ORM\Entities\Address::setCustomerId
     * @covers \Bigcommerce\ORM\Entities\Address::setFirstName
     * @covers \Bigcommerce\ORM\Entities\Address::setLastName
     * @covers \Bigcommerce\ORM\Entities\Address::setPhone
     * @covers \Bigcommerce\ORM\Entities\Address::setPostalCode
     * @covers \Bigcommerce\ORM\Entities\Address::setState
     * @covers \Bigcommerce\ORM\Entities\Address::getId
     * @covers \Bigcommerce\ORM\Entities\Address::getAddress1
     * @covers \Bigcommerce\ORM\Entities\Address::getAddress2
     * @covers \Bigcommerce\ORM\Entities\Address::getAddressType
     * @covers \Bigcommerce\ORM\Entities\Address::getCity
     * @covers \Bigcommerce\ORM\Entities\Address::getCompany
     * @covers \Bigcommerce\ORM\Entities\Address::getCountry
     * @covers \Bigcommerce\ORM\Entities\Address::getCountryCode
     * @covers \Bigcommerce\ORM\Entities\Address::getCustomerId
     * @covers \Bigcommerce\ORM\Entities\Address::getFirstName
     * @covers \Bigcommerce\ORM\Entities\Address::getLastName
     * @covers \Bigcommerce\ORM\Entities\Address::getPhone
     * @covers \Bigcommerce\ORM\Entities\Address::getPostalCode
     * @covers \Bigcommerce\ORM\Entities\Address::getState
     */
    public function testSettersAndGetters()
    {
        $this->address = new Address();
        $this->address->setId(1)
            ->setAddress1('add1')
            ->setAddress2('add2')
            ->setAddressType('home')
            ->setCity('sydney')
            ->setCompany('bc')
            ->setCountry('australia')
            ->setCountryCode('AU')
            ->setCustomerId(100)
            ->setFirstName('Ken')
            ->setLastName('Ngo')
            ->setPhone('0123456789')
            ->setPostalCode('2000')
            ->setState('NSW');

        $this->assertEquals(1, $this->address->getId());
        $this->assertEquals('add1', $this->address->getAddress1());
        $this->assertEquals('add2', $this->address->getAddress2());
        $this->assertEquals('home', $this->address->getAddressType());
        $this->assertEquals('sydney', $this->address->getCity());
        $this->assertEquals('bc', $this->address->getCompany());
        $this->assertEquals('australia', $this->address->getCountry());
        $this->assertEquals('AU', $this->address->getCountryCode());
        $this->assertEquals(100, $this->address->getCustomerId());
        $this->assertEquals('Ken', $this->address->getFirstName());
        $this->assertEquals('Ngo', $this->address->getLastName());
        $this->assertEquals('0123456789', $this->address->getPhone());
        $this->assertEquals('2000', $this->address->getPostalCode());
        $this->assertEquals('NSW', $this->address->getState());

    }
}