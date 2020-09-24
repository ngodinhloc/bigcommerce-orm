<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class OrderRefundPayment
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="OrderRefundPayment")
 */
class OrderRefundPayment extends AbstractEntity
{
    /**
     * @var int|string|null
     * @BC\Field(name="order_id", pathParam=true)
     */
    protected $orderId;

    /**
     * @var string|null
     * @BC\Field(name="provider_id")
     */
    protected $providerId;

    /**
     * @var float|null
     * @BC\Field(name="amount")
     */
    protected $amount;

    /**
     * @var bool
     * @BC\Field(name="offline")
     */
    protected $offline;

    /**
     * @var bool
     * @BC\Field(name="is_declined", readonly=true)
     */
    protected $isDeclined;

    /**
     * @var string|null
     * @BC\Field(name="declined_message", readonly=true)
     */
    protected $declinedMessage;

    /**
     * @return int|string|null
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int|string|null $orderId
     * @return \Bigcommerce\ORM\Entities\OrderRefundPayment
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProviderId(): ?string
    {
        return $this->providerId;
    }

    /**
     * @param string|null $providerId
     * @return \Bigcommerce\ORM\Entities\OrderRefundPayment
     */
    public function setProviderId(?string $providerId): OrderRefundPayment
    {
        $this->providerId = $providerId;

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
     * @return \Bigcommerce\ORM\Entities\OrderRefundPayment
     */
    public function setAmount(?float $amount): OrderRefundPayment
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOffline(): bool
    {
        return $this->offline;
    }

    /**
     * @param bool $offline
     * @return \Bigcommerce\ORM\Entities\OrderRefundPayment
     */
    public function setOffline(bool $offline): OrderRefundPayment
    {
        $this->offline = $offline;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDeclined(): bool
    {
        return $this->isDeclined;
    }

    /**
     * @param bool $isDeclined
     * @return \Bigcommerce\ORM\Entities\OrderRefundPayment
     */
    public function setIsDeclined(bool $isDeclined): OrderRefundPayment
    {
        $this->isDeclined = $isDeclined;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeclinedMessage(): ?string
    {
        return $this->declinedMessage;
    }

    /**
     * @param string|null $declinedMessage
     * @return \Bigcommerce\ORM\Entities\OrderRefundPayment
     */
    public function setDeclinedMessage(?string $declinedMessage): OrderRefundPayment
    {
        $this->declinedMessage = $declinedMessage;

        return $this;
    }
}