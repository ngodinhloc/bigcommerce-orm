<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Mapper;

/**
 * Class Payment
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Payment", path="/payments", type="payment", findable=false)
 */
class Payment extends AbstractEntity
{
    /**
     * @var int|string|null
     * @BC\Field(name="order_id")
     */
    protected $orderId;

    /**
     * @var array|null
     * @BC\Field(name="payment")
     */
    protected $paymentData;

    protected $paymentAccessTokenRequired = true;

    /** @var float|null */
    protected $amount;

    /** @var string|null */
    protected $currencyCode;

    /** @var \Bigcommerce\ORM\Entities\PaymentMethod */
    protected $paymentMethod;

    /** @var \Bigcommerce\ORM\Entities\AbstractInstrument */
    protected $paymentInstrument;

    /** @var \Bigcommerce\ORM\Mapper */
    protected $mapper;

    /**
     * Payment constructor.
     */
    public function __construct()
    {
        $this->mapper = new Mapper();
    }

    /**
     * @param \Bigcommerce\ORM\Entities\PaymentMethod|null $method
     * @return \Bigcommerce\ORM\Entities\Payment
     */
    public function setPaymentMethod(?PaymentMethod $method = null)
    {
        $this->paymentMethod = $method;
        $this->paymentData['payment_method_id'] = $method->getId();

        return $this;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\AbstractInstrument|null $instrument
     * @return \Bigcommerce\ORM\Entities\Payment
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function setPaymentInstrument(?AbstractInstrument $instrument = null)
    {
        $this->paymentInstrument = $instrument;
        $data = $this->mapper->getWritableFieldValues($instrument);
        $this->paymentData['instrument'] = $data;

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
     * @return \Bigcommerce\ORM\Entities\Payment
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getPaymentData(): ?array
    {
        return $this->paymentData;
    }

    /**
     * @param array|null $paymentData
     * @return \Bigcommerce\ORM\Entities\Payment
     */
    public function setPaymentData(?array $paymentData): Payment
    {
        $this->paymentData = $paymentData;

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
     * @return \Bigcommerce\ORM\Entities\Payment
     */
    public function setAmount(?float $amount): Payment
    {
        $this->amount = $amount;
        $this->paymentData['amount'] = $amount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    /**
     * @param string|null $currencyCode
     * @return \Bigcommerce\ORM\Entities\Payment
     */
    public function setCurrencyCode(?string $currencyCode): Payment
    {
        $this->currencyCode = $currencyCode;
        $this->paymentData['currency_code'] = $currencyCode;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Mapper
     */
    public function getMapper(): Mapper
    {
        return $this->mapper;
    }

    /**
     * @param \Bigcommerce\ORM\Mapper $mapper
     * @return \Bigcommerce\ORM\Entities\Payment
     */
    public function setMapper(\Bigcommerce\ORM\Mapper $mapper): Payment
    {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\PaymentMethod
     */
    public function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\AbstractInstrument
     */
    public function getPaymentInstrument(): AbstractInstrument
    {
        return $this->paymentInstrument;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\PaymentAccessToken|null $paymentAccessToken
     * @return \Bigcommerce\ORM\Entities\Payment
     */
    public function setPaymentAccessToken(?PaymentAccessToken $paymentAccessToken): Payment
    {
        $this->paymentAccessToken = $paymentAccessToken;

        return $this;
    }
}
