<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class ProductOption
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductOption", path="/catalog/products/{product_id}/options")
 */
class ProductOption extends Entity
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var string|null
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var string|null
     * @BC\Field(name="value")
     */
    protected $value;

    /**
     * @var string|null
     * @BC\Field(name="display_name")
     */
    protected $displayName;

    /**
     * @var string|null
     * @BC\Field(name="type")
     */
    protected $type;

    /**
     * @var int|null
     * @BC\Field(name="sort_order")
     */
    protected $sortOrder;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductOptionValue[]|null
     * @BC\HasMany(name="option_values", targetClass="\Bigcommerce\ORM\Entities\ProductOptionValue", field="id", targetField="option_id", from="result", auto=true)
     */
    protected $optionValues;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductOption
     */
    public function setProductId(?int $productId): ProductOption
    {
        $this->productId = $productId;
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
     * @return \Bigcommerce\ORM\Entities\ProductOption
     */
    public function setName(?string $name): ProductOption
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return \Bigcommerce\ORM\Entities\ProductOption
     */
    public function setValue(?string $value): ProductOption
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * @param string|null $displayName
     * @return \Bigcommerce\ORM\Entities\ProductOption
     */
    public function setDisplayName(?string $displayName): ProductOption
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return \Bigcommerce\ORM\Entities\ProductOption
     */
    public function setType(?string $type): ProductOption
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    /**
     * @param int|null $sortOrder
     * @return \Bigcommerce\ORM\Entities\ProductOption
     */
    public function setSortOrder(?int $sortOrder): ProductOption
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductOptionValue[]|null
     */
    public function getOptionValues(): ?array
    {
        return $this->optionValues;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductOptionValue[]|null $optionValues
     * @return \Bigcommerce\ORM\Entities\ProductOption
     */
    public function setOptionValues(?array $optionValues): ProductOption
    {
        $this->optionValues = $optionValues;
        return $this;
    }
}