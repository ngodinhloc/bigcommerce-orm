<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Mapper;

/**
 * Class Consignment
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Consignment", path="/checkouts/{checkout_id}/consignments", type="api",creatable=false)
 */
class Consignment extends AbstractEntity
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
     * @var \Bigcommerce\ORM\Entities\ShippingOption|null
     * @BC\HasOne(name="selected_shipping_option", targetClass="\Bigcommerce\ORM\Entities\ShippingOption", field="id", targetField="consignment_id", from="result", auto=true)
     */
    protected $selectedShippingOption;

    /**
     * @var \Bigcommerce\ORM\Entities\ShippingOption[]|null
     * @BC\HasMany(name="available_shipping_options", targetClass="\Bigcommerce\ORM\Entities\ShippingOption", field="id", targetField="consignment_id", from="result", auto=true)
     */
    protected $availableShippingOptions;

    /**
     * @var \Bigcommerce\ORM\Entities\ShippingAddress|null
     * @BC\HasOne(name="shipping_address", targetClass="\Bigcommerce\ORM\Entities\ShippingAddress", field="id", targetField="consignment_id", from="result", auto=true)
     */
    protected $checkoutShippingAddress;

    /** @var \Bigcommerce\ORM\Mapper */
    protected $mapper;

    /**
     * Consignment constructor.
     */
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
     * @return \Bigcommerce\ORM\Entities\Consignment
     */
    public function setShippingCostTotalIncTax(?float $shippingCostTotalIncTax): Consignment
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
     * @return \Bigcommerce\ORM\Entities\Consignment
     */
    public function setShippingCostTotalExTax(?float $shippingCostTotalExTax): Consignment
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
     * @return \Bigcommerce\ORM\Entities\Consignment
     */
    public function setHandlingCostTotalIncTax(?float $handlingCostTotalIncTax): Consignment
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
     * @return \Bigcommerce\ORM\Entities\Consignment
     */
    public function setHandlingCostTotalExTax(?float $handlingCostTotalExTax): Consignment
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
     * @return \Bigcommerce\ORM\Entities\Consignment
     */
    public function setCouponDiscounts(?array $couponDiscounts): Consignment
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
     * @return \Bigcommerce\ORM\Entities\Consignment
     */
    public function setDiscounts(?array $discounts): Consignment
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
     * @return \Bigcommerce\ORM\Entities\Consignment
     */
    public function setLineItemIds(?array $lineItemIds): Consignment
    {
        $this->lineItemIds = $lineItemIds;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ShippingOption|null
     */
    public function getSelectedShippingOption(): ?ShippingOption
    {
        return $this->selectedShippingOption;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ShippingOption|null $selectedShippingOption
     * @return \Bigcommerce\ORM\Entities\Consignment
     */
    public function setSelectedShippingOption(?ShippingOption $selectedShippingOption): Consignment
    {
        $this->selectedShippingOption = $selectedShippingOption;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ShippingAddress|null
     */
    public function getCheckoutShippingAddress(): ?ShippingAddress
    {
        return $this->checkoutShippingAddress;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ShippingAddress|null $checkoutShippingAddress
     * @return \Bigcommerce\ORM\Entities\Consignment
     */
    public function setCheckoutShippingAddress(?ShippingAddress $checkoutShippingAddress): Consignment
    {
        $this->checkoutShippingAddress = $checkoutShippingAddress;

        return $this;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\LineItem|null $item
     * @return \Bigcommerce\ORM\Entities\Consignment
     */
    public function addLineItem(?LineItem $item = null)
    {
        $this->lineItems[] = [
            'item_id' => $item->getId(),
            'quantity' => $item->getQuantity()
        ];

        return $this;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\AbstractAddress|null $address
     * @return \Bigcommerce\ORM\Entities\Consignment
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
     * @return \Bigcommerce\ORM\Entities\Consignment
     */
    public function setCheckoutId($checkoutId)
    {
        $this->checkoutId = $checkoutId;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ShippingOption[]|null
     */
    public function getAvailableShippingOptions(): ?array
    {
        return $this->availableShippingOptions;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ShippingOption|null $shippingOption
     * @return \Bigcommerce\ORM\Entities\Consignment
     */
    public function setShippingOption(?ShippingOption $shippingOption = null)
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