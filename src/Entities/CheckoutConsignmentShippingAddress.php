<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CheckoutConsignmentShippingAddress
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CheckoutConsignmentShippingAddress")
 */
class CheckoutConsignmentShippingAddress extends AbstractAddress
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
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingAddress
     */
    public function setEmail(?string $email): CheckoutConsignmentShippingAddress
    {
        $this->email = $email;

        return $this;
    }
}