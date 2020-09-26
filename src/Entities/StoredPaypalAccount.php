<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class StoredPaypalAccount
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="StoredPaypalAccount")
 */
class StoredPaypalAccount extends AbstractInstrument
{
    /**
     * @var string|null
     * @BC\Field(name="type")
     */
    protected $type = 'stored_paypal_account';

    /**
     * @var string|null
     * @BC\Field(name="token")
     */
    protected $token;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return \Bigcommerce\ORM\Entities\StoredPaypalAccount
     */
    public function setType(?string $type): StoredPaypalAccount
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     * @return \Bigcommerce\ORM\Entities\StoredPaypalAccount
     */
    public function setToken(?string $token): StoredPaypalAccount
    {
        $this->token = $token;

        return $this;
    }
}