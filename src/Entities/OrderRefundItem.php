<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class OrderRefundItem
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="OrderRefundItem")
 */
class OrderRefundItem extends AbstractEntity
{
    /**
     * @var int|string|null
     * @BC\Field(name="order_id", pathParam=true)
     */
    protected $orderId;

    /**
     * @var string|null
     * @BC\Field(name="item_type")
     */
    protected $itemType;

    /**
     * @var int|string|null
     * @BC\Field(name="item_id")
     */
    protected $itemId;

    /**
     * @var int|null
     * @BC\Field(name="quantity")
     */
    protected $quantity;

    /**
     * @var string|null
     * @BC\Field(name="reason")
     */
    protected $reason;

    /**
     * @var float|null
     * @BC\Field(name="amount")
     */
    protected $amount;

    /**
     * @var float|null
     * @BC\Field(name="requested_amount", readonly=true)
     */
    protected $requestedAmount;

    /**
     * @return int|string|null
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int|string|null $orderId
     * @return \Bigcommerce\ORM\Entities\OrderRefundItem
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getItemType(): ?string
    {
        return $this->itemType;
    }

    /**
     * @param string|null $itemType
     * @return \Bigcommerce\ORM\Entities\OrderRefundItem
     */
    public function setItemType(?string $itemType): OrderRefundItem
    {
        $this->itemType = $itemType;

        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param int|string|null $itemId
     * @return \Bigcommerce\ORM\Entities\OrderRefundItem
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     * @return \Bigcommerce\ORM\Entities\OrderRefundItem
     */
    public function setQuantity(?int $quantity): OrderRefundItem
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @param string|null $reason
     * @return \Bigcommerce\ORM\Entities\OrderRefundItem
     */
    public function setReason(?string $reason): OrderRefundItem
    {
        $this->reason = $reason;

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
     * @return \Bigcommerce\ORM\Entities\OrderRefundItem
     */
    public function setAmount(?float $amount): OrderRefundItem
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getRequestedAmount(): ?float
    {
        return $this->requestedAmount;
    }

    /**
     * @param float|null $requestedAmount
     * @return \Bigcommerce\ORM\Entities\OrderRefundItem
     */
    public function setRequestedAmount(?float $requestedAmount): OrderRefundItem
    {
        $this->requestedAmount = $requestedAmount;

        return $this;
    }
}