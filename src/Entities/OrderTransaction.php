<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class OrderTransaction
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="OrderTransaction", path="/orders/{order_id}/transactions", type="api")
 */
class OrderTransaction extends AbstractEntity
{
    /**
     * @var int|string|null
     * @BC\Field(name="order_id", pathParam=true)
     */
    protected $orderId;

    /**
     * @var string|null
     * @BC\Field(name="event")
     */
    protected $event;

    /**
     * @var string|null
     * @BC\Field(name="method")
     */
    protected $method;

    /**
     * @var float|null
     * @BC\Field(name="amount")
     */
    protected $amount;

    /**
     * @var string|null
     * @BC\Field(name="currency")
     */
    protected $currency;

    /**
     * @var string|null
     * @BC\Field(name="gateway")
     */
    protected $gateway;

    /**
     * @var string|null
     * @BC\Field(name="gateway_transaction_id")
     */
    protected $gatewayTransactionId;

    /**
     * @var string|null
     * @BC\Field(name="status")
     */
    protected $status;

    /**
     * @var bool
     * @BC\Field(name="test")
     */
    protected $test;

    /**
     * @var bool
     * @BC\Field(name="fraud_review")
     */
    protected $fraudReview;

    /**
     * @var array|null
     * @BC\Field(name="reference_transaction_id")
     */
    protected $referenceTransactionId;

    /**
     * @var string|null
     * @BC\Field(name="date_created")
     */
    protected $dateCreated;

    /**
     * @var array|null
     * @BC\Field(name="avs_result")
     */
    protected $avsResult;

    /**
     * @var array|null
     * @BC\Field(name="cvv_result")
     */
    protected $cvvResult;

    /**
     * @var array|null
     * @BC\Field(name="credit_card")
     */
    protected $creditCard;

    /**
     * @var array|null
     * @BC\Field(name="gift_certificate")
     */
    protected $giftCertificate;

    /**
     * @var array|null
     * @BC\Field(name="store_credit")
     */
    protected $storeCredit;

    /**
     * @var array|null
     * @BC\Field(name="offline")
     */
    protected $offline;

    /**
     * @var array|null
     * @BC\Field(name="custom")
     */
    protected $custom;

    /**
     * @var array|null
     * @BC\Field(name="payment_instrument_token")
     */
    protected $paymentInstrumentToken;

    /**
     * @var string|null
     * @BC\Field(name="payment_method_id")
     */
    protected $paymentMethodId;

    /**
     * @return int|string|null
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int|string|null $orderId
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEvent(): ?string
    {
        return $this->event;
    }

    /**
     * @param string|null $event
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setEvent(?string $event): OrderTransaction
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @param string|null $method
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setMethod(?string $method): OrderTransaction
    {
        $this->method = $method;

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
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setAmount(?float $amount): OrderTransaction
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setCurrency(?string $currency): OrderTransaction
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGateway(): ?string
    {
        return $this->gateway;
    }

    /**
     * @param string|null $gateway
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setGateway(?string $gateway): OrderTransaction
    {
        $this->gateway = $gateway;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGatewayTransactionId(): ?string
    {
        return $this->gatewayTransactionId;
    }

    /**
     * @param string|null $gatewayTransactionId
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setGatewayTransactionId(?string $gatewayTransactionId): OrderTransaction
    {
        $this->gatewayTransactionId = $gatewayTransactionId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setStatus(?string $status): OrderTransaction
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTest(): bool
    {
        return $this->test;
    }

    /**
     * @param bool $test
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setTest(bool $test): OrderTransaction
    {
        $this->test = $test;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFraudReview(): bool
    {
        return $this->fraudReview;
    }

    /**
     * @param bool $fraudReview
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setFraudReview(bool $fraudReview): OrderTransaction
    {
        $this->fraudReview = $fraudReview;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getReferenceTransactionId(): ?array
    {
        return $this->referenceTransactionId;
    }

    /**
     * @param array|null $referenceTransactionId
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setReferenceTransactionId(?array $referenceTransactionId): OrderTransaction
    {
        $this->referenceTransactionId = $referenceTransactionId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateCreated(): ?string
    {
        return $this->dateCreated;
    }

    /**
     * @param string|null $dateCreated
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setDateCreated(?string $dateCreated): OrderTransaction
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getAvsResult(): ?array
    {
        return $this->avsResult;
    }

    /**
     * @param array|null $avsResult
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setAvsResult(?array $avsResult): OrderTransaction
    {
        $this->avsResult = $avsResult;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getCvvResult(): ?array
    {
        return $this->cvvResult;
    }

    /**
     * @param array|null $cvvResult
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setCvvResult(?array $cvvResult): OrderTransaction
    {
        $this->cvvResult = $cvvResult;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getCreditCard(): ?array
    {
        return $this->creditCard;
    }

    /**
     * @param array|null $creditCard
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setCreditCard(?array $creditCard): OrderTransaction
    {
        $this->creditCard = $creditCard;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getGiftCertificate(): ?array
    {
        return $this->giftCertificate;
    }

    /**
     * @param array|null $giftCertificate
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setGiftCertificate(?array $giftCertificate): OrderTransaction
    {
        $this->giftCertificate = $giftCertificate;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getStoreCredit(): ?array
    {
        return $this->storeCredit;
    }

    /**
     * @param array|null $storeCredit
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setStoreCredit(?array $storeCredit): OrderTransaction
    {
        $this->storeCredit = $storeCredit;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getOffline(): ?array
    {
        return $this->offline;
    }

    /**
     * @param array|null $offline
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setOffline(?array $offline): OrderTransaction
    {
        $this->offline = $offline;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getCustom(): ?array
    {
        return $this->custom;
    }

    /**
     * @param array|null $custom
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setCustom(?array $custom): OrderTransaction
    {
        $this->custom = $custom;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getPaymentInstrumentToken(): ?array
    {
        return $this->paymentInstrumentToken;
    }

    /**
     * @param array|null $paymentInstrumentToken
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setPaymentInstrumentToken(?array $paymentInstrumentToken): OrderTransaction
    {
        $this->paymentInstrumentToken = $paymentInstrumentToken;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentMethodId(): ?string
    {
        return $this->paymentMethodId;
    }

    /**
     * @param string|null $paymentMethodId
     * @return \Bigcommerce\ORM\Entities\OrderTransaction
     */
    public function setPaymentMethodId(?string $paymentMethodId): OrderTransaction
    {
        $this->paymentMethodId = $paymentMethodId;

        return $this;
    }
}