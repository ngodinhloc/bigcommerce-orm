<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class BillingAddress
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="BillingAddress", path="/checkouts/{checkout_id}/billing-address", type="api", findable=false, deletable=false)
 */
class BillingAddress extends AbstractAddress
{
    /**
     * @var int|string|null
     * @BC\Field(name="checkout_id", readonly=true, pathParam=true)
     */
    protected $checkoutId;

    /**
     * @var string|null
     * @BC\Field(name="email")
     */
    protected $email;

    /**
     * @return int|string|null
     */
    public function getCheckoutId()
    {
        return $this->checkoutId;
    }

    /**
     * @param int|string|null $checkoutId
     * @return \Bigcommerce\ORM\Entities\BillingAddress
     */
    public function setCheckoutId($checkoutId)
    {
        $this->checkoutId = $checkoutId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return \Bigcommerce\ORM\Entities\BillingAddress
     */
    public function setEmail(?string $email): BillingAddress
    {
        $this->email = $email;

        return $this;
    }
}