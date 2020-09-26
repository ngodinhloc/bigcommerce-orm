<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class AbstractAddress
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="AbstractAddress")
 */
abstract class AbstractAddress extends AbstractEntity
{
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
    protected $stateOrProvince;

    /**
     * @var string|null
     * @BC\Field(name="state_or_province_code")
     */
    protected $stateOrProvinceCode;

    /**
     * @return string|null
     */
    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    /**
     * @param string|null $address1
     * @return \Bigcommerce\ORM\Entities\AbstractAddress
     */
    public function setAddress1(?string $address1): AbstractAddress
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
     * @return \Bigcommerce\ORM\Entities\AbstractAddress
     */
    public function setAddress2(?string $address2): AbstractAddress
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
     * @return \Bigcommerce\ORM\Entities\AbstractAddress
     */
    public function setAddressType(?string $addressType): AbstractAddress
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
     * @return \Bigcommerce\ORM\Entities\AbstractAddress
     */
    public function setCity(?string $city): AbstractAddress
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
     * @return \Bigcommerce\ORM\Entities\AbstractAddress
     */
    public function setCompany(?string $company): AbstractAddress
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
     * @return \Bigcommerce\ORM\Entities\AbstractAddress
     */
    public function setCountry(?string $country): AbstractAddress
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
     * @return \Bigcommerce\ORM\Entities\AbstractAddress
     */
    public function setCountryCode(?string $countryCode): AbstractAddress
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
     * @return \Bigcommerce\ORM\Entities\AbstractAddress
     */
    public function setFirstName(?string $firstName): AbstractAddress
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
     * @return \Bigcommerce\ORM\Entities\AbstractAddress
     */
    public function setLastName(?string $lastName): AbstractAddress
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
     * @return \Bigcommerce\ORM\Entities\AbstractAddress
     */
    public function setPhone(?string $phone): AbstractAddress
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
     * @return \Bigcommerce\ORM\Entities\AbstractAddress
     */
    public function setPostalCode(?string $postalCode): AbstractAddress
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStateOrProvince(): ?string
    {
        return $this->stateOrProvince;
    }

    /**
     * @param string|null $stateOrProvince
     * @return \Bigcommerce\ORM\Entities\AbstractAddress
     */
    public function setStateOrProvince(?string $stateOrProvince): AbstractAddress
    {
        $this->stateOrProvince = $stateOrProvince;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStateOrProvinceCode(): ?string
    {
        return $this->stateOrProvinceCode;
    }

    /**
     * @param string|null $stateOrProvinceCode
     * @return \Bigcommerce\ORM\Entities\AbstractAddress
     */
    public function setStateOrProvinceCode(?string $stateOrProvinceCode): AbstractAddress
    {
        $this->stateOrProvinceCode = $stateOrProvinceCode;

        return $this;
    }
}