<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class Address
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Address", path="/customers/addresses")
 */
class Address extends Entity
{
    /**
     * @var string
     * @BC\Field(name="customer_id")
     */
    protected $customerId;

    /**
     * @var string
     * @BC\Field(name="address1")
     */
    protected $address1;

    /**
     * @var string
     * @BC\Field(name="address2")
     */
    protected $address2;

    /**
     * @var string
     * @BC\Field(name="address_type")
     */
    protected $addressType;

    /**
     * @var string
     * @BC\Field(name="city")
     */
    protected $city;

    /**
     * @var string
     * @BC\Field(name="company")
     */
    protected $company;

    /**
     * @var string
     * @BC\Field(name="country")
     */
    protected $country;

    /**
     * @var string
     * @BC\Field(name="country_code")
     */
    protected $countryCode;

    /**
     * @var string
     * @BC\Field(name="first_name")
     */
    protected $firstName;

    /**
     * @var string
     * @BC\Field(name="last_name")
     */
    protected $lastName;

    /**
     * @var string
     * @BC\Field(name="phone")
     */
    protected $phone;

    /**
     * @var string
     * @BC\Field(name="postal_code")
     */
    protected $postalCode;

    /**
     * @var string
     * @BC\Field(name="state_or_province")
     */
    protected $state;

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     * @return \Bigcommerce\ORM\Entities\Address
     */
    public function setCustomerId(int $customerId): Address
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param string $address1
     * @return \Bigcommerce\ORM\Entities\Address
     */
    public function setAddress1(string $address1): Address
    {
        $this->address1 = $address1;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param string $address2
     * @return \Bigcommerce\ORM\Entities\Address
     */
    public function setAddress2(string $address2): Address
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddressType()
    {
        return $this->addressType;
    }

    /**
     * @param string $addressType
     * @return \Bigcommerce\ORM\Entities\Address
     */
    public function setAddressType(string $addressType): Address
    {
        $this->addressType = $addressType;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return \Bigcommerce\ORM\Entities\Address
     */
    public function setCity(string $city): Address
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     * @return \Bigcommerce\ORM\Entities\Address
     */
    public function setCompany(string $company): Address
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return \Bigcommerce\ORM\Entities\Address
     */
    public function setCountry(string $country): Address
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     * @return \Bigcommerce\ORM\Entities\Address
     */
    public function setCountryCode(string $countryCode): Address
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return \Bigcommerce\ORM\Entities\Address
     */
    public function setFirstName(string $firstName): Address
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return \Bigcommerce\ORM\Entities\Address
     */
    public function setLastName(string $lastName): Address
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return \Bigcommerce\ORM\Entities\Address
     */
    public function setPhone(string $phone): Address
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return \Bigcommerce\ORM\Entities\Address
     */
    public function setPostalCode(string $postalCode): Address
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return \Bigcommerce\ORM\Entities\Address
     */
    public function setState(string $state): Address
    {
        $this->state = $state;
        return $this;
    }

}