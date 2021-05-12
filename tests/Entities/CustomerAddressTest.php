<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CustomerAddress;
use Tests\BaseTestCase;

class CustomerAddressTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\CustomerAddress */
    protected $entity;

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
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setStateOrProvince
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
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getStateOrProvince
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::getStateOrProvinceCode
     * @covers \Bigcommerce\ORM\Entities\CustomerAddress::setStateOrProvinceCode
     */
    public function testSettersAndGetters()
    {
        $this->entity = new CustomerAddress();
        $this->entity->setId(1)
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
            ->setStateOrProvince('NSW')
            ->setStateOrProvinceCode('NSW');

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('add1', $this->entity->getAddress1());
        $this->assertEquals('add2', $this->entity->getAddress2());
        $this->assertEquals('home', $this->entity->getAddressType());
        $this->assertEquals('sydney', $this->entity->getCity());
        $this->assertEquals('bc', $this->entity->getCompany());
        $this->assertEquals('australia', $this->entity->getCountry());
        $this->assertEquals('AU', $this->entity->getCountryCode());
        $this->assertEquals(100, $this->entity->getCustomerId());
        $this->assertEquals('Ken', $this->entity->getFirstName());
        $this->assertEquals('Ngo', $this->entity->getLastName());
        $this->assertEquals('0123456789', $this->entity->getPhone());
        $this->assertEquals('2000', $this->entity->getPostalCode());
        $this->assertEquals('NSW', $this->entity->getStateOrProvince());
        $this->assertEquals('NSW', $this->entity->getStateOrProvinceCode());
    }
}
