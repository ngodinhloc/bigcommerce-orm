<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ProductModifier
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductModifier", path="/catalog/products/{product_id}/modifiers", type="api")
 */
class ProductModifier extends AbstractOption
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var bool
     * @BC\Field(name="required")
     */
    protected $required;

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

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param bool $required
     * @return \Bigcommerce\ORM\Entities\ProductModifier
     */
    public function setRequired(?bool $required): ProductModifier
    {
        $this->required = $required;

        return $this;
    }
}