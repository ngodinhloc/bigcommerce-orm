<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class ProductModifierValue
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductModifierValue", path="/catalog/products/{product_id}/modifiers/{option_id}/values")
 */
class ProductModifierValue extends Entity
{
    /**
     * @var int
     * @BC\Field(name="product_id", readonly=true, parent=true)
     */
    protected $productId;

    /**
     * @var int
     * @BC\Field(name="option_id", readonly=true, parent=true)
     */
    protected $modifierId;

    /**
     * @var string
     * @BC\Field(name="label", readonly=true)
     */
    protected $label;

    /**
     * @var int
     * @BC\Field(name="sort_order")
     */
    protected $sortOrder;

    /**
     * @var mixed
     * @BC\Field(name="value_data")
     */
    protected $valueData;

    /**
     * @var bool
     * @BC\Field(name="is_default")
     */
    protected $isDefault = false;

    /**
     * @var array
     * @BC\Field(name="adjusters")
     */
    protected $adjusters;

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setProductId(int $productId): ProductModifierValue
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return int
     */
    public function getModifierId()
    {
        return $this->modifierId;
    }

    /**
     * @param int $modifierId
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setModifierId(int $modifierId): ProductModifierValue
    {
        $this->modifierId = $modifierId;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setLabel(string $label): ProductModifierValue
    {
        $this->label = $label;
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
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setSortOrder(int $sortOrder): ProductModifierValue
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValueData()
    {
        return $this->valueData;
    }

    /**
     * @param mixed $valueData
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setValueData($valueData)
    {
        $this->valueData = $valueData;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return $this->isDefault;
    }

    /**
     * @param bool $isDefault
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setIsDefault(bool $isDefault): ProductModifierValue
    {
        $this->isDefault = $isDefault;
        return $this;
    }

    /**
     * @return array
     */
    public function getAdjusters()
    {
        return $this->adjusters;
    }

    /**
     * @param array $adjusters
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setAdjusters(array $adjusters): ProductModifierValue
    {
        $this->adjusters = $adjusters;
        return $this;
    }
}