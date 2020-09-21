<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class Cart
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Cart", path="/carts", type="api")
 */
class Cart extends Entity
{
    /**
     * @var string|null
     * @BC\Field(name="id", readonly=true)
     */
    protected $id;

    /**
     * @var string|null
     * @BC\Field(name="parent_id")
     */
    protected $parentId;

    /**
     * @var int|null
     * @BC\Field(name="customer_id")
     */
    protected $customerId;

    /**
     * @var string|null
     * @BC\Field(name="email")
     */
    protected $email;

    /**
     * @var array|null
     * @BC\Field(name="currency")
     */
    protected $currency;

    /**
     * @var bool
     * @BC\Field(name="tax_included")
     */
    protected $taxIncluded;

    /**
     * @var float|null
     * @BC\Field(name="base_amount")
     */
    protected $baseAmount;

    /**
     * @var float|null
     * @BC\Field(name="discount_amount")
     */
    protected $discountAmount;

    /**
     * @var float|null
     * @BC\Field(name="cart_amount")
     */
    protected $cartAmount;

    /**
     * @var string|null
     * @BC\Field(name="created_time")
     */
    protected $createdTime;

    /**
     * @var string|null
     * @BC\Field(name="updated_time")
     */
    protected $updatedTime;

    /**
     * @var int|null
     * @BC\Field(name="channel_id")
     */
    protected $channelId;

    /**
     * @var array|null
     * @BC\Field(name="coupons")
     */
    protected $coupons;

    /**
     * @var array|null
     * @BC\Field(name="discounts")
     */
    protected $discounts;

    /**
     * @var array|null
     * @BC\Field(name="line_items")
     */
    protected $lineItems;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param int|string|null $id
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setId($id = null): Cart
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    /**
     * @param string|null $parentId
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setParentId(?string $parentId): Cart
    {
        $this->parentId = $parentId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    /**
     * @param int|null $customerId
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setCustomerId(?int $customerId): Cart
    {
        $this->customerId = $customerId;
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
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setEmail(?string $email): Cart
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getCurrency(): ?array
    {
        return $this->currency;
    }

    /**
     * @param array|null $currency
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setCurrency(?array $currency): Cart
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTaxIncluded(): bool
    {
        return $this->taxIncluded;
    }

    /**
     * @param bool $taxIncluded
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setTaxIncluded(bool $taxIncluded): Cart
    {
        $this->taxIncluded = $taxIncluded;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getBaseAmount(): ?float
    {
        return $this->baseAmount;
    }

    /**
     * @param float|null $baseAmount
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setBaseAmount(?float $baseAmount): Cart
    {
        $this->baseAmount = $baseAmount;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getDiscountAmount(): ?float
    {
        return $this->discountAmount;
    }

    /**
     * @param float|null $discountAmount
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setDiscountAmount(?float $discountAmount): Cart
    {
        $this->discountAmount = $discountAmount;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getCartAmount(): ?float
    {
        return $this->cartAmount;
    }

    /**
     * @param float|null $cartAmount
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setCartAmount(?float $cartAmount): Cart
    {
        $this->cartAmount = $cartAmount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCreatedTime(): ?string
    {
        return $this->createdTime;
    }

    /**
     * @param string|null $createdTime
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setCreatedTime(?string $createdTime): Cart
    {
        $this->createdTime = $createdTime;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUpdatedTime(): ?string
    {
        return $this->updatedTime;
    }

    /**
     * @param string|null $updatedTime
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setUpdatedTime(?string $updatedTime): Cart
    {
        $this->updatedTime = $updatedTime;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getChannelId(): ?int
    {
        return $this->channelId;
    }

    /**
     * @param int|null $channelId
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setChannelId(?int $channelId): Cart
    {
        $this->channelId = $channelId;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getCoupons(): ?array
    {
        return $this->coupons;
    }

    /**
     * @param array|null $coupons
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setCoupons(?array $coupons): Cart
    {
        $this->coupons = $coupons;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getDiscounts(): ?array
    {
        return $this->discounts;
    }

    /**
     * @param array|null $discounts
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setDiscounts(?array $discounts): Cart
    {
        $this->discounts = $discounts;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getLineItems(): ?array
    {
        return $this->lineItems;
    }

    /**
     * @param array|null $lineItems
     * @return \Bigcommerce\ORM\Entities\Cart
     */
    public function setLineItems(?array $lineItems): Cart
    {
        $this->lineItems = $lineItems;
        return $this;
    }
}