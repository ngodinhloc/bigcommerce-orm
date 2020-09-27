<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class Order
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Order", path="/checkouts/{checkout_id}/orders", type="api", deletable=false, updatable=false)
 */
class Order extends AbstractEntity
{
    /**
     * @var int|string|null
     * @BC\Field(name="checkout_id", pathParam=true)
     */
    protected $checkoutId;

    /**
     * @var bool
     * @BC\Field(name="is_recurring")
     */
    protected $isRecurring = false;

    /**
     * @return int|string|null
     */
    public function getCheckoutId()
    {
        return $this->checkoutId;
    }

    /**
     * @param int|string|null $checkoutId
     * @return \Bigcommerce\ORM\Entities\Order
     */
    public function setCheckoutId($checkoutId)
    {
        $this->checkoutId = $checkoutId;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRecurring(): bool
    {
        return $this->isRecurring;
    }

    /**
     * @param bool|null $isRecurring
     * @return Order
     */
    public function setIsRecurring(bool $isRecurring): Order
    {
        $this->isRecurring = $isRecurring;

        return $this;
    }
}