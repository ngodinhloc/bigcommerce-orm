<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CheckoutBillingAddress
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CheckoutBillingAddress", path="/checkouts/{checkout_id}/billing-address", type="api", findable=false, deletable=false)
 */
class CheckoutBillingAddress extends AbstractAddress
{
    /**
     * @var string|null
     * @BC\Field(name="email")
     */
    protected $email;

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return \Bigcommerce\ORM\Entities\CheckoutBillingAddress
     */
    public function setEmail(?string $email): CheckoutBillingAddress
    {
        $this->email = $email;

        return $this;
    }
}