<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ProductModifier
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductModifier", path="/catalog/products/{product_id}/modifiers", type="api")
 */
class ProductModifier extends AbstractEntity
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
     * @BC\Field(name="display_name")
     */
    protected $displayName;

    /**
     * @var string|null
     * @BC\Field(name="type")
     */
    protected $type;

    /**
     * @var bool|null
     * @BC\Field(name="required")
     */
    protected $required;

    /**
     * @var int|null
     * @BC\Field(name="sort_order")
     */
    protected $sortOrder;

    /**
     * @var array|null
     * @BC\Field(name="config")
     */
    protected $config;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductModifierValue[]|null
     * @BC\HasMany(name="option_values", targetClass="\Bigcommerce\ORM\Entities\ProductModifierValue", field="id", targetField="option_id", from="result", auto=true)
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
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setProductId(?int $productId): ProductModifier
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
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setName(?string $name): ProductModifier
    {
        $this->name = $name;

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
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setDisplayName(?string $displayName): ProductModifier
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
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setType(?string $type): ProductModifier
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isRequired(): ?bool
    {
        return $this->required;
    }

    /**
     * @param bool|null $required
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setRequired(?bool $required): ProductModifier
    {
        $this->required = $required;

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
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setSortOrder(?int $sortOrder): ProductModifier
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getConfig(): ?array
    {
        return $this->config;
    }

    /**
     * @param array|null $config
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setConfig(?array $config): ProductModifier
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue[]|null
     */
    public function getOptionValues(): ?array
    {
        return $this->optionValues;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductModifierValue[]|null $optionValues
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setOptionValues(?array $optionValues): ProductModifier
    {
        $this->optionValues = $optionValues;

        return $this;
    }
}