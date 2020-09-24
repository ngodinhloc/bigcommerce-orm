<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class AbstractAttributeValue
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="AbstractAttributeValue")
 */
abstract class AbstractAttributeValue extends AbstractEntity
{
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
    public function getAttributeId(): ?int
    {
        return $this->attributeId;
    }

    /**
     * @param int|null $attributeId
     * @return \Bigcommerce\ORM\Entities\AbstractAttributeValue
     */
    public function setAttributeId(?int $attributeId): AbstractAttributeValue
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
     * @return \Bigcommerce\ORM\Entities\AbstractAttributeValue
     */
    public function setAttributeValue(?string $attributeValue): AbstractAttributeValue
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
     * @return \Bigcommerce\ORM\Entities\AbstractAttributeValue
     */
    public function setDateCreated(?string $dateCreated): AbstractAttributeValue
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
     * @return \Bigcommerce\ORM\Entities\AbstractAttributeValue
     */
    public function setDateModified(?string $dateModified): AbstractAttributeValue
    {
        $this->dateModified = $dateModified;

        return $this;
    }
}