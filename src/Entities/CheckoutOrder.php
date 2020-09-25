<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CheckoutOrder
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ChecCheckoutOrderkout", path="/checkouts/{checkout_id}/orders", type="api", deletable=false, updatable=false)
 */
class CheckoutOrder extends AbstractEntity
{
    /**
     * @var int|string|null
     * @BC\Field(name="checkout_id", pathParam=true)
     */
    protected $checkoutId;

    /**
     * @return int|string|null
     */
    public function getCheckoutId()
    {
        return $this->checkoutId;
    }

    /**
     * @param int|string|null $checkoutId
     * @return \Bigcommerce\ORM\Entities\CheckoutOrder
     */
    public function setCheckoutId($checkoutId)
    {
        $this->checkoutId = $checkoutId;

        return $this;
    }
}