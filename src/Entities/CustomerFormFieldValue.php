<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CustomerFormFieldValue
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CustomerFormFieldValue", path="/customers/form-field-values", type="api")
 */
class CustomerFormFieldValue extends AbstractEntity
{
    /**
     * @var int|null
     * @BC\Field(name="customer_id")
     */
    protected $customerId;

    /**
     * @var int|null
     * @BC\Field(name="address_id")
     */
    protected $addressId;

    /**
     * @var string|null
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var mixed|null
     * @BC\Field(name="value")
     */
    protected $value;

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    /**
     * @param int|null $customerId
     * @return \Bigcommerce\ORM\Entities\CustomerFormFieldValue
     */
    public function setCustomerId(?int $customerId): CustomerFormFieldValue
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAddressId(): ?int
    {
        return $this->addressId;
    }

    /**
     * @param int|null $addressId
     * @return \Bigcommerce\ORM\Entities\CustomerFormFieldValue
     */
    public function setAddressId(?int $addressId): CustomerFormFieldValue
    {
        $this->addressId = $addressId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\CustomerFormFieldValue
     */
    public function setName(?string $name): CustomerFormFieldValue
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed|null $value
     * @return \Bigcommerce\ORM\Entities\CustomerFormFieldValue
     */
    public function setValue($value): CustomerFormFieldValue
    {
        $this->value = $value;

        return $this;
    }
}