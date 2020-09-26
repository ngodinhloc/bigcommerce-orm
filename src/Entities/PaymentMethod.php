<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class PaymentAcceptedMethod
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="PaymentAcceptedMethod", path="/payments/methods", type="api", findable=false)
 */
class PaymentMethod extends AbstractEntity
{
    /**
     * @var int|string|null
     * @BC\Field(name="order_id")
     */
    protected $orderId;

    /**
     * @var string|null
     * @BC\Field(name="name", readonly=true)
     */
    protected $name;

    /**
     * @var bool
     * @BC\Field(name="test_mode", readonly=true)
     */
    protected $testMode;

    /**
     * @var string|null
     * @BC\Field(name="type", readonly=true)
     */
    protected $type;

    /**
     * @var array|null
     * @BC\Field(name="supported_instruments", readonly=true)
     */
    protected $supportedInstruments;

    /**
     * @var array|null
     * @BC\Field(name="stored_instruments", readonly=true)
     */
    protected $storeInstruments;

    /**
     * @return int|string|null
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int|string|null $orderId
     * @return \Bigcommerce\ORM\Entities\PaymentMethod
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\PaymentMethod
     */
    public function setName(?string $name): PaymentMethod
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTestMode(): bool
    {
        return $this->testMode;
    }

    /**
     * @param bool $testMode
     * @return \Bigcommerce\ORM\Entities\PaymentMethod
     */
    public function setTestMode(bool $testMode): PaymentMethod
    {
        $this->testMode = $testMode;

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
     * @return \Bigcommerce\ORM\Entities\PaymentMethod
     */
    public function setType(?string $type): PaymentMethod
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getSupportedInstruments(): ?array
    {
        return $this->supportedInstruments;
    }

    /**
     * @param array|null $supportedInstruments
     * @return \Bigcommerce\ORM\Entities\PaymentMethod
     */
    public function setSupportedInstruments(?array $supportedInstruments): PaymentMethod
    {
        $this->supportedInstruments = $supportedInstruments;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getStoreInstruments(): ?array
    {
        return $this->storeInstruments;
    }

    /**
     * @param array|null $storeInstruments
     * @return \Bigcommerce\ORM\Entities\PaymentMethod
     */
    public function setStoreInstruments(?array $storeInstruments): PaymentMethod
    {
        $this->storeInstruments = $storeInstruments;

        return $this;
    }
}