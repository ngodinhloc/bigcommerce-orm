<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class PaymentAccessToken
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="PaymentAccessToken", path="/payments/access_tokens", type="api")
 */
class PaymentAccessToken extends AbstractEntity
{
    /**
     * @var array|null
     * @BC\Field(name="order")
     */
    protected $order;

    /**
     * @return array|null
     */
    public function getOrder(): ?array
    {
        return $this->order;
    }

    /**
     * @param array|null $order
     * @return \Bigcommerce\ORM\Entities\PaymentAccessToken
     */
    public function setOrder(?array $order): PaymentAccessToken
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CheckoutOrder|null $order
     * @return \Bigcommerce\ORM\Entities\PaymentAccessToken
     */
    public function setCheckoutOrder(?CheckoutOrder $order = null)
    {
        $this->order = [
            'id' => $order->getId(),
            'is_recurring' => $order->isRecurring()
        ];

        return $this;
    }
}