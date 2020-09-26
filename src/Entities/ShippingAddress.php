<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ShippingAddress
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ShippingAddress")
 */
class ShippingAddress extends AbstractAddress
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
     * @return \Bigcommerce\ORM\Entities\ShippingAddress
     */
    public function setEmail(?string $email): ShippingAddress
    {
        $this->email = $email;

        return $this;
    }
}