<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CustomerAddress
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CustomerAddress", path="/customers/addresses", type="api")
 */
class CustomerAddress extends AbstractAddress
{
    /**
     * @var int|null
     * @BC\Field(name="customer_id")
     */
    protected $customerId;

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    /**
     * @param int|null $customerId
     * @return \Bigcommerce\ORM\Entities\CustomerAddress
     */
    public function setCustomerId(?int $customerId): CustomerAddress
    {
        $this->customerId = $customerId;

        return $this;
    }
}