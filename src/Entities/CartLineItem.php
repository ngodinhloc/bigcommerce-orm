<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CartLineItem
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CartLineItem")
 */
class CartLineItem extends AbstractEntity
{
    /**
     * @var string|null
     * @BC\Field(name="cart_id", readonly=true)
     */
    protected $cartId;

    /**
     * @var string|null
     * @BC\Field(name="parent_id", readonly=true)
     */
    protected $parentId;

    /**
     * @var int|null
     * @BC\Field(name="variant_id", readonly=true)
     */
    protected $variantId;

    /**
     * @var int|null
     * @BC\Field(name="product_id")
     */
    protected $productId;

    /**
     * @var string|null
     * @BC\Field(name="sku", readonly=true)
     */
    protected $sku;

    /**
     * @var string|null
     * @BC\Field(name="name", readonly=true)
     */
    protected $name;

    /**
     * @var string|null
     * @BC\Field(name="url", readonly=true)
     */
    protected $url;

    /**
     * @var int|null
     * @BC\Field(name="quantity")
     */
    protected $quantity;

    /**
     * @var bool
     * @BC\Field(name="taxable", readonly=true)
     */
    protected $taxable;

    /**
     * @var string|null
     * @BC\Field(name="image_url", readonly=true)
     */
    protected $imageUrl;

    /**
     * @var array|null
     * @BC\Field(name="dicounts", readonly=true)
     */
    protected $discounts;

    /**
     * @var array|null
     * @BC\Field(name="coupons", readonly=true)
     */
    protected $coupons;

    /**
     * @var float|null
     * @BC\Field(name="discount_amount", readonly=true)
     */
    protected $discountAmount;

    /**
     * @var float|null
     * @BC\Field(name="coupon_amount", readonly=true)
     */
    protected $couponAmount;

    /**
     * @var float|null
     * @BC\Field(name="list_price")
     */
    protected $listPrice;

    /**
     * @var float|null
     * @BC\Field(name="sale_price", readonly=true)
     */
    protected $salePrice;

    /**
     * @var float|null
     * @BC\Field(name="extended_list_price", readonly=true)
     */
    protected $extendedListPrice;

    /**
     * @var float|null
     * @BC\Field(name="extended_sale_price", readonly=true)
     */
    protected $extendedSalePrice;

    /**
     * @var bool
     * @BC\Field(name="is_require_shipping", readonly=true)
     */
    protected $isRequiredShipping;

    /**
     * @var bool
     * @BC\Field(name="is_mutable", readonly=true)
     */
    protected $isMutable;

    /**
     * @var array|null
     * @BC\Field(name="option_selections")
     */
    protected $optionSelections;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\CartLineItem
     */
    public function setProductId(?int $productId): CartLineItem
    {
        $this->productId = $productId;

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
     * @return \Bigcommerce\ORM\Entities\CartLineItem
     */
    public function setQuantity(?int $quantity): CartLineItem
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getListPrice(): ?float
    {
        return $this->listPrice;
    }

    /**
     * @param float|null $listPrice
     * @return \Bigcommerce\ORM\Entities\CartLineItem
     */
    public function setListPrice(?float $listPrice): CartLineItem
    {
        $this->listPrice = $listPrice;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getOptionSelections(): ?array
    {
        return $this->optionSelections;
    }

    /**
     * @param array|null $optionSelections
     * @return \Bigcommerce\ORM\Entities\CartLineItem
     */
    public function setOptionSelections(?array $optionSelections): CartLineItem
    {
        $this->optionSelections = $optionSelections;

        return $this;
    }
}