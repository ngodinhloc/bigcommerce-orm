<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class Customer
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Customer", path="/customers", type="api", findable=false, creatable=false)
 */
class Customer extends Entity
{
    /**
     * @var string|null
     * @BC\Field(name="company")
     */
    protected $company;

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
     * @BC\Field(name="email")
     * @BC\Email(validate=true)
     */
    protected $email;

    /**
     * @var string|null
     * @BC\Field(name="phone")
     */
    protected $phone;

    /**
     * @var string|null
     * @BC\Field(name="date_created", readonly=true)
     * @BC\Date()
     */
    protected $dateCreated;

    /**
     * @var string|null
     * @BC\Field(name="date_modified", readonly=true)
     * @BC\Date()
     */
    protected $dateModified;

    /**
     * @var \Bigcommerce\ORM\Entities\CustomerAddress[]|null
     * @BC\HasMany(name="addresses", targetClass="\Bigcommerce\ORM\Entities\CustomerAddress", field="id", targetField="customer_id", from="include", auto=true)
     */
    protected $addresses;

    /**
     * @return string|null
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * @param string|null $company
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setCompany(?string $company): Customer
    {
        $this->company = $company;
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
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setFirstName(?string $firstName): Customer
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
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setLastName(?string $lastName): Customer
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setEmail(?string $email): Customer
    {
        $this->email = $email;
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
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setPhone(?string $phone): Customer
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateCreated(): ?string
    {
        return $this->dateCreated;
    }

    /**
     * @param string|null $dateCreated
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setDateCreated(?string $dateCreated): Customer
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateModified(): ?string
    {
        return $this->dateModified;
    }

    /**
     * @param string|null $dateModified
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setDateModified(?string $dateModified): Customer
    {
        $this->dateModified = $dateModified;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CustomerAddress[]|null
     */
    public function getAddresses(): ?array
    {
        return $this->addresses;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CustomerAddress[]|null $addresses
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setAddresses(?array $addresses): Customer
    {
        $this->addresses = $addresses;
        return $this;
    }
}