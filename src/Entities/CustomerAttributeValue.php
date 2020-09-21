<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class CustomerAttributeValue
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CustomerAttributeValue", path="/customers/attribute-values", type="api")
 */
class CustomerAttributeValue extends Entity
{
    /**
     * @var int|null
     * @BC\Field(name="customer_id")
     */
    protected $customerId;

    /**
     * @var int|null
     * @BC\Field(name="attribute_id")
     */
    protected $attributeId;

    /**
     * @var string|null
     * @BC\Field(name="attribute_value")
     */
    protected $attributeValue;

    /**
     * @var string|null
     * @BC\Field(name="date_created", readonly=true)
     */
    protected $dateCreated;

    /**
     * @var string|null
     * @BC\Field(name="date_modified", readonly=true)
     */
    protected $dateModified;

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    /**
     * @param int|null $customerId
     * @return \Bigcommerce\ORM\Entities\CustomerAttributeValue
     */
    public function setCustomerId(?int $customerId): CustomerAttributeValue
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAttributeId(): ?int
    {
        return $this->attributeId;
    }

    /**
     * @param int|null $attributeId
     * @return \Bigcommerce\ORM\Entities\CustomerAttributeValue
     */
    public function setAttributeId(?int $attributeId): CustomerAttributeValue
    {
        $this->attributeId = $attributeId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttributeValue(): ?string
    {
        return $this->attributeValue;
    }

    /**
     * @param string|null $attributeValue
     * @return \Bigcommerce\ORM\Entities\CustomerAttributeValue
     */
    public function setAttributeValue(?string $attributeValue): CustomerAttributeValue
    {
        $this->attributeValue = $attributeValue;
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
     * @return \Bigcommerce\ORM\Entities\CustomerAttributeValue
     */
    public function setDateCreated(?string $dateCreated): CustomerAttributeValue
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
     * @return \Bigcommerce\ORM\Entities\CustomerAttributeValue
     */
    public function setDateModified(?string $dateModified): CustomerAttributeValue
    {
        $this->dateModified = $dateModified;
        return $this;
    }
}