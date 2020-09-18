<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class CustomerAttributeValue
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CustomerAttributeValue", path="/customers/attribute-values")
 */
class CustomerAttributeValue extends Entity
{
    /**
     * @var int
     * @BC\Field(name="customer_id")
     */
    protected $customerId;

    /**
     * @var int
     * @BC\Field(name="attribute_id")
     */
    protected $attributeId;

    /**
     * @var string
     * @BC\Field(name="attribute_value")
     */
    protected $attributeValue;

    /**
     * @var string
     * @BC\Field(name="date_created", readonly=true)
     */
    protected $dateCreated;

    /**
     * @var string
     * @BC\Field(name="date_modified", readonly=true)
     */
    protected $dateModified;

    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param int|null $customerId
     * @return \Bigcommerce\ORM\Entities\CustomerAttributeValue
     */
    public function setCustomerId(int $customerId = null): CustomerAttributeValue
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttributeId()
    {
        return $this->attributeId;
    }

    /**
     * @param int|null $attributeId
     * @return \Bigcommerce\ORM\Entities\CustomerAttributeValue
     */
    public function setAttributeId(int $attributeId = null): CustomerAttributeValue
    {
        $this->attributeId = $attributeId;
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
     * @return \Bigcommerce\ORM\Entities\CustomerAttributeValue
     */
    public function setDateCreated(string $dateCreated = null): CustomerAttributeValue
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
     * @return \Bigcommerce\ORM\Entities\CustomerAttributeValue
     */
    public function setDateModified(string $dateModified = null): CustomerAttributeValue
    {
        $this->dateModified = $dateModified;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttributeValue()
    {
        return $this->attributeValue;
    }

    /**
     * @param string|null $attributeValue
     * @return \Bigcommerce\ORM\Entities\CustomerAttributeValue
     */
    public function setAttributeValue(string $attributeValue = null): CustomerAttributeValue
    {
        $this->attributeValue = $attributeValue;
        return $this;
    }
}