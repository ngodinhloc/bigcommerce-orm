<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Mapper;

/**
 * Class OrderRefundQuote
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="OrderRefundQuote", path="/orders/{order_id}/payment_actions/refund_quotes", type="api")
 */
class OrderRefundQuote extends AbstractEntity
{
    /**
     * @var int|string|null
     * @BC\Field(name="order_id", pathParam=true, readonly=true)
     */
    protected $orderId;

    /**
     * @var float|null
     * @BC\Field(name="total_refund_amount", readonly=true)
     */
    protected $totalRefundAmount;

    /**
     * @var float|null
     * @BC\Field(name="total_refund_tax_amount", readonly=trues)
     */
    protected $totalRefundTaxAmount;

    /**
     * @var int|null
     * @BC\Field(name="rounding", readonly=true)
     */
    protected $rounding;

    /**
     * @var float|null
     * @BC\Field(name="adjustment", readonly=true)
     */
    protected $adjustment;

    /**
     * @var bool
     * @BC\Field(name="tax_inclusive", readonly=true)
     */
    protected $taxInclusive;

    /**
     * @var array|null
     * @BC\Field(name="refund_methods", readonly=true)
     */
    protected $refundMethods;

    /**
     * @var float|null
     * @BC\Field(name="tax_adjustment_amount")
     */
    protected $taxAdjustmentAmount;

    /**
     * @var array|null
     * @BC\Field(name="items")
     */
    protected $items;

    /** @var \Bigcommerce\ORM\Mapper */
    protected $mapper;

    public function __construct()
    {
        $this->mapper = new Mapper();
    }

    /**
     * @return int|string|null
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int|string|null $orderId
     * @return OrderRefundQuote
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTotalRefundAmount(): ?float
    {
        return $this->totalRefundAmount;
    }

    /**
     * @return float|null
     */
    public function getTotalRefundTaxAmount(): ?float
    {
        return $this->totalRefundTaxAmount;
    }

    /**
     * @return int|null
     */
    public function getRounding(): ?int
    {
        return $this->rounding;
    }

    /**
     * @return float|null
     */
    public function getAdjustment(): ?float
    {
        return $this->adjustment;
    }

    /**
     * @return bool
     */
    public function isTaxInclusive(): ?bool
    {
        return $this->taxInclusive;
    }

    /**
     * @return array|null
     */
    public function getRefundMethods(): ?array
    {
        return $this->refundMethods;
    }

    /**
     * @return float|null
     */
    public function getTaxAdjustmentAmount(): ?float
    {
        return $this->taxAdjustmentAmount;
    }

    /**
     * @param float|null $taxAdjustmentAmount
     * @return OrderRefundQuote
     */
    public function setTaxAdjustmentAmount(?float $taxAdjustmentAmount): OrderRefundQuote
    {
        $this->taxAdjustmentAmount = $taxAdjustmentAmount;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * @param array|null $items
     * @return OrderRefundQuote
     */
    public function setItems(?array $items): OrderRefundQuote
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\OrderRefundItem|null $item
     * @return $this
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function addRefundItem(?OrderRefundItem $item)
    {
        $data = $this->mapper->getWritableFieldValues($item);
        $this->items[] = $data;

        return $this;
    }
}