<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class CustomerAddress
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CustomerAddress", path="/customers/addresses")
 */
class CustomerAddress extends Entity
{
    /**
     * @var int|null
     * @BC\Field(name="customer_id")
     */
    protected $customerId;

    /**
     * @var string|null
     * @BC\Field(name="address1")
     */
    protected $address1;

    /**
     * @var string|null
     * @BC\Field(name="address2")
     */
    protected $address2;

    /**
     * @var string|null
     * @BC\Field(name="address_type")
     */
    protected $addressType;

    /**
     * @var string|null
     * @BC\Field(name="city")
     */
    protected $city;

    /**
     * @var string|null
     * @BC\Field(name="company")
     */
    protected $company;

    /**
     * @var string|null
     * @BC\Field(name="country")
     */
    protected $country;

    /**
     * @var string|null
     * @BC\Field(name="country_code")
     */
    protected $countryCode;

    /**
     * @var string|null
     * @BC\Field(name="first_name")
     */
    protected $firstName;

    /**
     * @var string|null
     * @BC\Field(name="last_name")
     */
    protected $lastName;

    /**
     * @var string|null
     * @BC\Field(name="phone")
     */
    protected $phone;

    /**
     * @var string|null
     * @BC\Field(name="postal_code")
     */
    protected $postalCode;

    /**
     * @var string|null
     * @BC\Field(name="state_or_province")
     */
    protected $state;

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    /**
     * @param int|null $customerId
     * @return \Bigcommerce\ORM\Entities\CustomerAddress
     */
    public function setCustomerId(?int $customerId): CustomerAddress
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    /**
     * @param string|null $address1
     * @return \Bigcommerce\ORM\Entities\CustomerAddress
     */
    public function setAddress1(?string $address1): CustomerAddress
    {
        $this->address1 = $address1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    /**
     * @param string|null $address2
     * @return \Bigcommerce\ORM\Entities\CustomerAddress
     */
    public function setAddress2(?string $address2): CustomerAddress
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddressType(): ?string
    {
        return $this->addressType;
    }

    /**
     * @param string|null $addressType
     * @return \Bigcommerce\ORM\Entities\CustomerAddress
     */
    public function setAddressType(?string $addressType): CustomerAddress
    {
        $this->addressType = $addressType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return \Bigcommerce\ORM\Entities\CustomerAddress
     */
    public function setCity(?string $city): CustomerAddress
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * @param string|null $company
     * @return \Bigcommerce\ORM\Entities\CustomerAddress
     */
    public function setCompany(?string $company): CustomerAddress
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     * @return \Bigcommerce\ORM\Entities\CustomerAddress
     */
    public function setCountry(?string $country): CustomerAddress
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @param string|null $countryCode
     * @return \Bigcommerce\ORM\Entities\CustomerAddress
     */
    public function setCountryCode(?string $countryCode): CustomerAddress
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     * @return \Bigcommerce\ORM\Entities\CustomerAddress
     */
    public function setFirstName(?string $firstName): CustomerAddress
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     * @return \Bigcommerce\ORM\Entities\CustomerAddress
     */
    public function setLastName(?string $lastName): CustomerAddress
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return \Bigcommerce\ORM\Entities\CustomerAddress
     */
    public function setPhone(?string $phone): CustomerAddress
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string|null $postalCode
     * @return \Bigcommerce\ORM\Entities\CustomerAddress
     */
    public function setPostalCode(?string $postalCode): CustomerAddress
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     * @return \Bigcommerce\ORM\Entities\CustomerAddress
     */
    public function setState(?string $state): CustomerAddress
    {
        $this->state = $state;
        return $this;
    }
}