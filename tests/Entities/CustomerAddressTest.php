<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CustomerAddress;
use Tests\BaseTestCase;

class CustomerAddressTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CustomerAddress */
    protected $address;

    /**
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setId
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setAddress1
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setAddress2
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setAddressType
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setCity
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setCompany
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setCountry
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setCountryCode
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setCustomerId
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setFirstName
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setLastName
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setPhone
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setPostalCode
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setState
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getId
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getAddress1
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getAddress2
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getAddressType
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getCity
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getCompany
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getCountry
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getCountryCode
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getCustomerId
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getFirstName
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getLastName
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getPhone
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getPostalCode
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getState
     */
    public function testSettersAndGetters()
    {
        $this->address = new CustomerAddress();
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