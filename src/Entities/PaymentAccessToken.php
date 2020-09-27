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
    protected $orderValue;

    /**
     * @return array|null
     */
    public function getOrderValue(): ?array
    {
        return $this->orderValue;
    }

    /**
     * @param array|null $orderValue
     * @return \Bigcommerce\ORM\Entities\PaymentAccessToken
     */
    public function setOrderValue(?array $orderValue): PaymentAccessToken
    {
        $this->orderValue = $orderValue;

        return $this;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\Order|null $order
     * @return \Bigcommerce\ORM\Entities\PaymentAccessToken
     */
    public function setOrder(?Order $order = null)
    {
        $this->orderValue = [
            'id' => $order->getId(),
            'is_recurring' => $order->isRecurring()
        ];

        return $this;
    }
}