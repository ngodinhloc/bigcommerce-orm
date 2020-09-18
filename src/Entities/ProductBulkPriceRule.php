<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class ProductBulkPriceRule
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductBulkPriceRule",path="/catalog/products/{product_id}/bulk-pricing-rules")
 */
class ProductBulkPriceRule extends Entity
{
    /**
     * @var int
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var int
     * @BC\Field(name="quantity_min")
     */
    protected $quantityMin;

    /**
     * @var int
     * @BC\Field(name="quantity_max")
     */
    protected $quantityMax;

    /**
     * @var string
     * @BC\Field(name="type")
     */
    protected $type;

    /**
     * @var float
     * @BC\Field(name="amount")
     */
    protected $amount;

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductBulkPriceRule
     */
    public function setProductId(int $productId = null): ProductBulkPriceRule
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantityMin()
    {
        return $this->quantityMin;
    }

    /**
     * @param int|null $quantityMin
     * @return \Bigcommerce\ORM\Entities\ProductBulkPriceRule
     */
    public function setQuantityMin(int $quantityMin = null): ProductBulkPriceRule
    {
        $this->quantityMin = $quantityMin;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantityMax()
    {
        return $this->quantityMax;
    }

    /**
     * @param int|null $quantityMax
     * @return \Bigcommerce\ORM\Entities\ProductBulkPriceRule
     */
    public function setQuantityMax(int $quantityMax = null): ProductBulkPriceRule
    {
        $this->quantityMax = $quantityMax;
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
     * @param string|null $type
     * @return \Bigcommerce\ORM\Entities\ProductBulkPriceRule
     */
    public function setType(string $type = null): ProductBulkPriceRule
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float|null $amount
     * @return \Bigcommerce\ORM\Entities\ProductBulkPriceRule
     */
    public function setAmount(float $amount = null): ProductBulkPriceRule
    {
        $this->amount = $amount;
        return $this;
    }

}