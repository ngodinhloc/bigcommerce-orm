<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class GiftCertificate
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="GiftCertificate")
 */
class GiftCertificate extends AbstractEntity
{
    /**
     * @var string|null
     * @BC\Field(name="cart_id", readonly=true)
     */
    protected $cartId;

    /**
     * @var string|null
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var string|null
     * @BC\Field(name="theme")
     */
    protected $theme;

    /**
     * @var float|null
     * @BC\Field(name="amount")
     */
    protected $amount;

    /**
     * @var int|null
     * @BC\Field(name="quantity")
     */
    protected $quantity;

    /**
     * @var array|null
     * @BC\Field(name="sender")
     */
    protected $sender;

    /**
     * @var array|null
     * @BC\Field(name="recipient")
     */
    protected $recipient;

    /**
     * @var string|null
     * @BC\Field(name="message")
     */
    protected $message;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\GiftCertificate
     */
    public function setName(?string $name): GiftCertificate
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTheme(): ?string
    {
        return $this->theme;
    }

    /**
     * @param string|null $theme
     * Birthday, Boy, Celebration, Christmas, General, Girl
     * @return \Bigcommerce\ORM\Entities\GiftCertificate
     */
    public function setTheme(?string $theme): GiftCertificate
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float|null $amount
     * @return \Bigcommerce\ORM\Entities\GiftCertificate
     */
    public function setAmount(?float $amount): GiftCertificate
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     * @return \Bigcommerce\ORM\Entities\GiftCertificate
     */
    public function setQuantity(?int $quantity): GiftCertificate
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getSender(): ?array
    {
        return $this->sender;
    }

    /**
     * @param array|null $sender
     * @return \Bigcommerce\ORM\Entities\GiftCertificate
     */
    public function setSender(?array $sender): GiftCertificate
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getRecipient(): ?array
    {
        return $this->recipient;
    }

    /**
     * @param array|null $recipient
     * @return \Bigcommerce\ORM\Entities\GiftCertificate
     */
    public function setRecipient(?array $recipient): GiftCertificate
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return \Bigcommerce\ORM\Entities\GiftCertificate
     */
    public function setMessage(?string $message): GiftCertificate
    {
        $this->message = $message;

        return $this;
    }
}