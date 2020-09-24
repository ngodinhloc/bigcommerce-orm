<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CustomerAttribute
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CustomerAttribute", path="/customers/attributes", type="api")
 */
class CustomerAttribute extends AbstractAttribute
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
     * @return \Bigcommerce\ORM\Entities\CustomerAttribute
     */
    public function setCustomerId(?int $customerId): CustomerAttribute
    {
        $this->customerId = $customerId;

        return $this;
    }
}