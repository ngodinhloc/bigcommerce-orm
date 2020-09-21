<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class ProductModifierValue
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductModifierValue", path="/catalog/products/{product_id}/modifiers/{option_id}/values", type="api")
 */
class ProductModifierValue extends Entity
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
    protected $modifierId;

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
     * @BC\Field(name="value_data")
     */
    protected $valueData;

    /**
     * @var bool|null
     * @BC\Field(name="is_default")
     */
    protected $isDefault;

    /**
     * @var array|null
     * @BC\Field(name="adjusters")
     */
    protected $adjusters;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setProductId(?int $productId): ProductModifierValue
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getModifierId(): ?int
    {
        return $this->modifierId;
    }

    /**
     * @param int|null $modifierId
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setModifierId(?int $modifierId): ProductModifierValue
    {
        $this->modifierId = $modifierId;
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
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setLabel(?string $label): ProductModifierValue
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
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setSortOrder(?int $sortOrder): ProductModifierValue
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
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setValueData($valueData): ProductModifierValue
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
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setIsDefault(?bool $isDefault): ProductModifierValue
    {
        $this->isDefault = $isDefault;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getAdjusters(): ?array
    {
        return $this->adjusters;
    }

    /**
     * @param array|null $adjusters
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setAdjusters(?array $adjusters): ProductModifierValue
    {
        $this->adjusters = $adjusters;
        return $this;
    }
}