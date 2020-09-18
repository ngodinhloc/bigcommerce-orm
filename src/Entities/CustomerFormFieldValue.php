<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class CustomerFormFieldValue
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CustomerFormFieldValue", path="/customers/form-field-values")
 */
class CustomerFormFieldValue extends Entity
{
    /**
     * @var int
     * @BC\Field(name="customer_id")
     */
    protected $customerId;

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
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param int|null $customerId
     * @return \Bigcommerce\ORM\Entities\CustomerFormFieldValue
     */
    public function setCustomerId(int $customerId = null): CustomerFormFieldValue
    {
        $this->customerId = $customerId;
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
     * @return \Bigcommerce\ORM\Entities\CustomerFormFieldValue
     */
    public function setName(string $name = null): CustomerFormFieldValue
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed|null $value
     * @return \Bigcommerce\ORM\Entities\CustomerFormFieldValue
     */
    public function setValue($value = null): CustomerFormFieldValue
    {
        $this->value = $value;
        return $this;
    }

}