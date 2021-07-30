<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Mapper;

/**
 * Class OrderRefund
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="OrderRefund", path="/orders/{order_id}/payment_actions/refunds", type="api")
 */
class OrderRefund extends AbstractEntity
{
    /**
     * @var int|string|null
     * @BC\Field(name="order_id", readonly=true, pathParam=true)
     */
    protected $orderId;

    /**
     * @var int|null
     * @BC\Field(name="user_id", readonly=true)
     */
    protected $userId;

    /**
     * @var string|null
     * @BC\Field(name="created", readonly=true)
     */
    protected $created;

    /**
     * @var string|null
     * @BC\Field(name="reason", readonly=true)
     */
    protected $reason;

    /**
     * @var float|null
     * @BC\Field(name="total_amount", readonly=true)
     */
    protected $totalAmount;

    /**
     * @var float|null
     * @BC\Field(name="total_tax", readonly=true)
     */
    protected $totalTax;

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

    /**
     * @var array|null
     * @BC\Field(name="payments")
     */
    protected $payments;

    /** @var \Bigcommerce\ORM\Mapper */
    protected $mapper;

    /**
     * OrderRefund constructor.
     */
    public function __construct()
    {
        $this->mapper = new Mapper();
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
     * @return OrderRefund
     */
    public function setTaxAdjustmentAmount(?float $taxAdjustmentAmount): OrderRefund
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
     * @return OrderRefund
     */
    public function setItems(?array $items): OrderRefund
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getPayments(): ?array
    {
        return $this->payments;
    }

    /**
     * @param array|null $payments
     * @return OrderRefund
     */
    public function setPayments(?array $payments): OrderRefund
    {
        $this->payments = $payments;

        return $this;
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
     * @return OrderRefund
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getCreated(): ?string
    {
        return $this->created;
    }

    /**
     * @return string|null
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @return float|null
     */
    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    /**
     * @return float|null
     */
    public function getTotalTax(): ?float
    {
        return $this->totalTax;
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

    /**
     * @param \Bigcommerce\ORM\Entities\OrderRefundPayment|null $payment
     * @return $this
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function addRefundPayment(?OrderRefundPayment $payment)
    {
        $data = $this->mapper->getWritableFieldValues($payment);
        $this->payments[] = $data;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\OrderRefundItem[]|null
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getRefundItems()
    {
        if (empty($this->items)) {
            return null;
        }

        return $this->mapper->getEntityPatcher()->patchArrayToCollection($this->items, OrderRefundItem::class, ['order_id' => $this->orderId]);
    }

    /**
     * @return \Bigcommerce\ORM\Entities\OrderRefundPayment[]|null
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getRefundPayments()
    {
        if (empty($this->payments)) {
            return null;
        }

        return $this->mapper->getEntityPatcher()->patchArrayToCollection($this->payments, OrderRefundPayment::class, ['order_id' => $this->orderId]);
    }
}
