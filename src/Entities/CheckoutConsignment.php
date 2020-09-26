<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Mapper;

/**
 * Class CheckoutConsignment
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CheckoutConsignment", path="/checkouts/{checkout_id}/consignments", type="api",creatable=false)
 */
class CheckoutConsignment extends AbstractEntity
{
    /**
     * @var int|string|null
     * @BC\Field(name="checkout_id", pathParam=true, readonly=true)
     */
    protected $checkoutId;

    /**
     * @var float|null
     * @BC\Field(name="shipping_cost_total_inc_tax", readonly=true)
     */
    protected $shippingCostTotalIncTax;

    /**
     * @var float|null
     * @BC\Field(name="shipping_cost_total_ex_tax", readonly=true)
     */
    protected $shippingCostTotalExTax;

    /**
     * @var float|null
     * @BC\Field(name="handling_cost_total_inc_tax", readonly=true)
     */
    protected $handlingCostTotalIncTax;

    /**
     * @var float|null
     * @BC\Field(name="handling_cost_total_ex_tax", readonly=true)
     */
    protected $handlingCostTotalExTax;

    /**
     * @var array|null
     * @BC\Field(name="coupon_discounts", readonly=true)
     */
    protected $couponDiscounts;

    /**
     * @var array|null
     * @BC\Field(name="discounts", readonly=true)
     */
    protected $discounts;

    /**
     * @var array|null
     * @BC\Field(name="line_item_ids", readonly=true)
     */
    protected $lineItemIds;
    /**
     * @var array|null
     * @BC\Field(name="line_items")
     */
    protected $lineItems;

    /**
     * @var array|null
     * @BC\Field(name="shipping_address")
     */
    protected $shippingAddress;

    /**
     * @var int|string|null
     * @BC\Field(name="shipping_option_id")
     */
    protected $shippingOptionId;

    /**
     * @var \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption|null
     * @BC\HasOne(name="selected_shipping_option", targetClass="\Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption", field="id", targetField="consignment_id", from="include", auto=true)
     */
    protected $selectedShippingOption;

    /**
     * @var \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption[]|null
     * @BC\HasMany(name="available_shipping_options", targetClass="\Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption", field="id", targetField="consignment_id", from="include", auto=true)
     */
    protected $availableShippingOptions;

    /**
     * @var \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingAddress|null
     * @BC\HasOne(name="shipping_address", targetClass="\Bigcommerce\ORM\Entities\CheckoutConsignmentShippingAddress", field="id", targetField="consignment_id", from="result", auto=true)
     */
    protected $checkoutShippingAddress;

    /** @var \Bigcommerce\ORM\Mapper */
    protected $mapper;

    public function __construct()
    {
        $this->mapper = new Mapper();
    }

    /**
     * @return float|null
     */
    public function getShippingCostTotalIncTax(): ?float
    {
        return $this->shippingCostTotalIncTax;
    }

    /**
     * @param float|null $shippingCostTotalIncTax
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     */
    public function setShippingCostTotalIncTax(?float $shippingCostTotalIncTax): CheckoutConsignment
    {
        $this->shippingCostTotalIncTax = $shippingCostTotalIncTax;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getShippingCostTotalExTax(): ?float
    {
        return $this->shippingCostTotalExTax;
    }

    /**
     * @param float|null $shippingCostTotalExTax
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     */
    public function setShippingCostTotalExTax(?float $shippingCostTotalExTax): CheckoutConsignment
    {
        $this->shippingCostTotalExTax = $shippingCostTotalExTax;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getHandlingCostTotalIncTax(): ?float
    {
        return $this->handlingCostTotalIncTax;
    }

    /**
     * @param float|null $handlingCostTotalIncTax
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     */
    public function setHandlingCostTotalIncTax(?float $handlingCostTotalIncTax): CheckoutConsignment
    {
        $this->handlingCostTotalIncTax = $handlingCostTotalIncTax;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getHandlingCostTotalExTax(): ?float
    {
        return $this->handlingCostTotalExTax;
    }

    /**
     * @param float|null $handlingCostTotalExTax
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     */
    public function setHandlingCostTotalExTax(?float $handlingCostTotalExTax): CheckoutConsignment
    {
        $this->handlingCostTotalExTax = $handlingCostTotalExTax;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getCouponDiscounts(): ?array
    {
        return $this->couponDiscounts;
    }

    /**
     * @param array|null $couponDiscounts
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     */
    public function setCouponDiscounts(?array $couponDiscounts): CheckoutConsignment
    {
        $this->couponDiscounts = $couponDiscounts;

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
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     */
    public function setDiscounts(?array $discounts): CheckoutConsignment
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
     * @return array|null
     */
    public function getShippingAddress(): ?array
    {
        return $this->shippingAddress;
    }

    /**
     * @return array|null
     */
    public function getLineItemIds(): ?array
    {
        return $this->lineItemIds;
    }

    /**
     * @param array|null $lineItemIds
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     */
    public function setLineItemIds(?array $lineItemIds): CheckoutConsignment
    {
        $this->lineItemIds = $lineItemIds;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption|null
     */
    public function getSelectedShippingOption(): ?CheckoutConsignmentShippingOption
    {
        return $this->selectedShippingOption;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption|null $selectedShippingOption
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     */
    public function setSelectedShippingOption(?CheckoutConsignmentShippingOption $selectedShippingOption): CheckoutConsignment
    {
        $this->selectedShippingOption = $selectedShippingOption;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingAddress|null
     */
    public function getCheckoutShippingAddress(): ?CheckoutConsignmentShippingAddress
    {
        return $this->checkoutShippingAddress;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingAddress|null $checkoutShippingAddress
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     */
    public function setCheckoutShippingAddress(?CheckoutConsignmentShippingAddress $checkoutShippingAddress): CheckoutConsignment
    {
        $this->checkoutShippingAddress = $checkoutShippingAddress;

        return $this;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CartLineItem|null $item
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     */
    public function addLineItem(?CartLineItem $item = null)
    {
        $this->lineItems[] = [
            'item_id' => $item->getId(),
            'quantity' => $item->getQuantity()
        ];

        return $this;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\AbstractAddress|null $address
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function setShippingAddress(?AbstractAddress $address = null)
    {
        $data = $this->mapper->getWritableFieldValues($address);
        $this->shippingAddress = $data;

        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getCheckoutId()
    {
        return $this->checkoutId;
    }

    /**
     * @param int|string|null $checkoutId
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     */
    public function setCheckoutId($checkoutId)
    {
        $this->checkoutId = $checkoutId;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption[]|null
     */
    public function getAvailableShippingOptions(): ?array
    {
        return $this->availableShippingOptions;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption|null $shippingOption
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     */
    public function setShippingOption(?CheckoutConsignmentShippingOption $shippingOption = null)
    {
        $this->shippingOptionId = $shippingOption->getId();

        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getShippingOptionId()
    {
        return $this->shippingOptionId;
    }
}