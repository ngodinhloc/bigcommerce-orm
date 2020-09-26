<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class StoredCard
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="StoredCard")
 */
class StoredCard extends AbstractInstrument
{
    /**
     * @var string|null
     * @BC\Field(name="type")
     */
    protected $type = 'card';

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
     * @return \Bigcommerce\ORM\Entities\StoredCard
     */
    public function setType(?string $type): StoredCard
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
     * @return \Bigcommerce\ORM\Entities\StoredCard
     */
    public function setToken(?string $token): StoredCard
    {
        $this->token = $token;

        return $this;
    }
}