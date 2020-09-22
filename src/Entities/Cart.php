<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;
use Bigcommerce\ORM\Mapper;

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
    protected $channelId = 1;

    /**
     * @var \Bigcommerce\ORM\Entities\CartCoupon|null
     * @BC\HasMany(name="coupons", targetClass="\Bigcommerce\ORM\Entities\CartCoupon", field="id", targetField="cart_id", from="result", auto=true)
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
     * @var array|null
     * @BC\Field(name="custom_items")
     */
    protected $customItems = [];

    /**
     * @var array|null
     * @BC\Field(name="gift_certificates")
     */
    protected $giftCertificates = [];

    /**
     * @var array|null
     * @BC\Field(name="redirect_urls")
     */
    protected $redirectUrls;

    /** @var \Bigcommerce\ORM\Mapper */
    protected $mapper;

    public function __construct()
    {
        $this->mapper = new Mapper();
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
     * @return bool|null
     */
    public function isTaxIncluded(): ?bool
    {
        return $this->taxIncluded;
    }

    /**
     * @return float|null
     */
    public function getBaseAmount(): ?float
    {
        return $this->baseAmount;
    }

    /**
     * @return float|null
     */
    public function getDiscountAmount(): ?float
    {
        return $this->discountAmount;
    }

    /**
     * @return float|null
     */
    public function getCartAmount(): ?float
    {
        return $this->cartAmount;
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
     * @return array|\Bigcommerce\ORM\Entities\CartCoupon|null
     */
    public function getCoupons(): ?array
    {
        return $this->coupons;
    }

    /**
     * @return array|null
     */
    public function getDiscounts(): ?array
    {
        return $this->discounts;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CartCustomItem[]|null
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getCustomItems()
    {
        if (empty($this->lineItems['custom_items'])) {
            return null;
        }

        return $this->mapper->arrayToCollection($this->lineItems['custom_items'], CartCustomItem::class, ['cart_id' => $this->id]);
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CartGiftCertificate[]|null
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getGiftCertificates()
    {
        if (empty($this->lineItems['gift_certificates'])) {
            return null;
        }

        return $this->mapper->arrayToCollection($this->lineItems['gift_certificates'], CartGiftCertificate::class, ['cart_id' => $this->id]);
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CartLineItem[]|null
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getDigitalLineItems()
    {
        if (empty($this->lineItems['digital_items'])) {
            return null;
        }

        return $this->mapper->arrayToCollection($this->lineItems['digital_items'], CartLineItem::class, ['cart_id' => $this->id]);
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CartLineItem[]|null
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getPhysicalLineItems()
    {
        if (empty($this->lineItems['physical_items'])) {
            return null;
        }

        return $this->mapper->arrayToCollection($this->lineItems['physical_items'], CartLineItem::class, ['cart_id' => $this->id]);
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CartLineItem|null $item
     * @return \Bigcommerce\ORM\Entities\Cart
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function addLineItem(?CartLineItem $item)
    {
        $data = $this->mapper->getWritableFieldValues($item);
        $this->lineItems[] = $data;

        return $this;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CartCustomItem|null $item
     * @return \Bigcommerce\ORM\Entities\Cart
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function addCustomItem(?CartCustomItem $item)
    {
        $data = $this->mapper->getWritableFieldValues($item);
        $this->customItems[] = $data;

        return $this;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CartGiftCertificate|null $item
     * @return \Bigcommerce\ORM\Entities\Cart
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function addGiftCertificate(?CartGiftCertificate $item)
    {
        $data = $this->mapper->getWritableFieldValues($item);
        $this->giftCertificates[] = $data;

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

    /**
     * @return array|null
     */
    public function getRedirectUrls(): ?array
    {
        return $this->redirectUrls;
    }
}