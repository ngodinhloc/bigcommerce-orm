<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class ProductOptionValue
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductOptionValue", path="/catalog/products/{product_id}/options/{option_id}/values")
 */
class ProductOptionValue extends Entity
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var int|null
     * @BC\Field(name="option_id", readonly=true, pathParam=true)
     */
    protected $optionId;

    /**
     * @var string|null
     * @BC\Field(name="label")
     */
    protected $label;

    /**
     * @var int|null
     * @BC\Field(name="sort_order")
     */
    protected $sortOrder;

    /**
     * @var mixed|null
     * @BC\Field(name="value_date")
     */
    protected $valueData;

    /**
     * @var bool|null
     * @BC\Field(name="is_default")
     */
    protected $isDefault = false;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductOptionValue
     */
    public function setProductId(?int $productId): ProductOptionValue
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOptionId(): ?int
    {
        return $this->optionId;
    }

    /**
     * @param int|null $optionId
     * @return \Bigcommerce\ORM\Entities\ProductOptionValue
     */
    public function setOptionId(?int $optionId): ProductOptionValue
    {
        $this->optionId = $optionId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     * @return \Bigcommerce\ORM\Entities\ProductOptionValue
     */
    public function setLabel(?string $label): ProductOptionValue
    {
        $this->label = $label;
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
     * @return \Bigcommerce\ORM\Entities\ProductOptionValue
     */
    public function setSortOrder(?int $sortOrder): ProductOptionValue
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getValueData()
    {
        return $this->valueData;
    }

    /**
     * @param mixed|null $valueData
     * @return \Bigcommerce\ORM\Entities\ProductOptionValue
     */
    public function setValueData($valueData): ProductOptionValue
    {
        $this->valueData = $valueData;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isDefault(): ?bool
    {
        return $this->isDefault;
    }

    /**
     * @param bool|null $isDefault
     * @return \Bigcommerce\ORM\Entities\ProductOptionValue
     */
    public function setIsDefault(?bool $isDefault): ProductOptionValue
    {
        $this->isDefault = $isDefault;
        return $this;
    }
}