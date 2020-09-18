<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class AddressFormFieldValue
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="AddressFormFieldValue", path="/customers/form-field-values")
 */
class AddressFormFieldValue extends Entity
{
    /**
     * @var int
     * @BC\Field(name="address_id")
     */
    protected $addressId;

    /**
     * @var string
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var mixed
     * @BC\Field(name="value")
     */
    protected $value;

    /**
     * @return string
     */
    public function getAddressId()
    {
        return $this->addressId;
    }

    /**
     * @param int|null $addressId
     * @return \Bigcommerce\ORM\Entities\AddressFormFieldValue
     */
    public function setAddressId(int $addressId = null): AddressFormFieldValue
    {
        $this->addressId = $addressId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\AddressFormFieldValue
     */
    public function setName(string $name = null): AddressFormFieldValue
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return \Bigcommerce\ORM\Entities\AddressFormFieldValue
     */
    public function setValue($value = null): AddressFormFieldValue
    {
        $this->value = $value;
        return $this;
    }

}