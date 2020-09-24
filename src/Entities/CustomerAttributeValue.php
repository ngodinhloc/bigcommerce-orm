<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CustomerAttributeValue
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CustomerAttributeValue", path="/customers/attribute-values", type="api")
 */
class CustomerAttributeValue extends AbstractAttributeValue
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
     * @return \Bigcommerce\ORM\Entities\CustomerAttributeValue
     */
    public function setCustomerId(?int $customerId): CustomerAttributeValue
    {
        $this->customerId = $customerId;

        return $this;
    }
}