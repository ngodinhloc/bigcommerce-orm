<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class Customer
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Customer",path="/customers")
 */
class Customer extends Entity
{
    /**
     * @var string
     * @BC\Field(name="company")
     */
    protected $company;

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
     * @BC\Field(name="email")
     * @BC\Email(validate=true)
     */
    protected $email;

    /**
     * @var string
     * @BC\Field(name="phone")
     */
    protected $phone;

    /**
     * @var string
     * @BC\Field(name="date_created", readonly=true)
     * @BC\Date()
     */
    protected $dateCreated;

    /**
     * @var string
     * @BC\Field(name="date_modified", readonly=true)
     * @BC\Date()
     */
    protected $dateModified;

    /**
     * @var \Bigcommerce\ORM\Entities\Address[]
     * @BC\HasMany(name="addresses", targetClass="\Bigcommerce\ORM\Entities\Address", field="id", targetField="customer_id", from="include", auto=true)
     */
    protected $addresses = [];

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string|null $company
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setCompany(string $company = null): Customer
    {
        $this->company = $company;

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
     * @param string|null $firstName
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setFirstName(string $firstName = null): Customer
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
     * @param string|null $lastName
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setLastName(string $lastName = null): Customer
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setEmail(string $email = null): Customer
    {
        $this->email = $email;

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
     * @param string|null $phone
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setPhone(string $phone = null): Customer
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param string|null $dateCreated
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setDateCreated(string $dateCreated = null): Customer
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * @param string|null $dateModified
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setDateModified(string $dateModified = null): Customer
    {
        $this->dateModified = $dateModified;
        return $this;
    }


    /**
     * @return \Bigcommerce\ORM\Entities\Address[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\Address[] $addresses
     * @return \Bigcommerce\ORM\Entities\Customer
     */
    public function setAddresses(array $addresses): Customer
    {
        $this->addresses = $addresses;
        return $this;
    }

}