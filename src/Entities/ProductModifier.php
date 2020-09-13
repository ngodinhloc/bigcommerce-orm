<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class ProductModifier
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductModifier", path="/catalog/products/{product_id}/modifiers")
 */
class ProductModifier extends Entity
{
    /**
     * @var int
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var string
     * @BC\Field(name="name", readonly=true)
     */
    protected $name;

    /**
     * @var string
     * @BC\Field(name="display_name")
     */
    protected $displayName;

    /**
     * @var string
     * @BC\Field(name="type")
     */
    protected $type;

    /**
     * @var bool
     * @BC\Field(name="required")
     */
    protected $required = false;

    /**
     * @var int
     * @BC\Field(name="sort_order")
     */
    protected $sortOrder;

    /**
     * @var array
     * @BC\Field(name="config")
     */
    protected $config;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductModifierValue[]
     * @BC\HasMany(name="option_values", targetClass="\Bigcommerce\ORM\Entities\ProductModifierValue", field="id", targetField="option_id", from="result", auto=true)
     */
    protected $optionValues;

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setProductId(int $productId): ProductModifier
    {
        $this->productId = $productId;
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
     * @param string $name
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setName(string $name): ProductModifier
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setDisplayName(string $displayName): ProductModifier
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setType(string $type): ProductModifier
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param bool $required
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setRequired(bool $required): ProductModifier
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param int $sortOrder
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setSortOrder(int $sortOrder): ProductModifier
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setConfig(array $config): ProductModifier
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue[]
     */
    public function getOptionValues()
    {
        return $this->optionValues;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductModifierValue[] $optionValues
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setOptionValues(array $optionValues): ProductModifier
    {
        $this->optionValues = $optionValues;
        return $this;
    }

}