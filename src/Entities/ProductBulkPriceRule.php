<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ProductBulkPriceRule
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductBulkPriceRule", path="/catalog/products/{product_id}/bulk-pricing-rules", type="api")
 */
class ProductBulkPriceRule extends AbstractEntity
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var int|null
     * @BC\Field(name="quantity_min")
     */
    protected $quantityMin;

    /**
     * @var int|null
     * @BC\Field(name="quantity_max")
     */
    protected $quantityMax;

    /**
     * @var string|null
     * @BC\Field(name="type")
     */
    protected $type;

    /**
     * @var float|null
     * @BC\Field(name="amount")
     */
    protected $amount;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductBulkPriceRule
     */
    public function setProductId(?int $productId): ProductBulkPriceRule
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantityMin(): ?int
    {
        return $this->quantityMin;
    }

    /**
     * @param int|null $quantityMin
     * @return \Bigcommerce\ORM\Entities\ProductBulkPriceRule
     */
    public function setQuantityMin(?int $quantityMin): ProductBulkPriceRule
    {
        $this->quantityMin = $quantityMin;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantityMax(): ?int
    {
        return $this->quantityMax;
    }

    /**
     * @param int|null $quantityMax
     * @return \Bigcommerce\ORM\Entities\ProductBulkPriceRule
     */
    public function setQuantityMax(?int $quantityMax): ProductBulkPriceRule
    {
        $this->quantityMax = $quantityMax;

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
     * @return \Bigcommerce\ORM\Entities\ProductBulkPriceRule
     */
    public function setType(?string $type): ProductBulkPriceRule
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float|null $amount
     * @return \Bigcommerce\ORM\Entities\ProductBulkPriceRule
     */
    public function setAmount(?float $amount): ProductBulkPriceRule
    {
        $this->amount = $amount;

        return $this;
    }
}