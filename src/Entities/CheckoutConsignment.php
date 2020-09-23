<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CheckoutConsignment
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CheckoutConsignment", path="/checkouts/{checkout_id}/consignments", type="api")
 */
class CheckoutConsignment extends AbstractEntity
{
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
     * @var \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption|null
     * @BC\HasOne(name="selected_shipping_option", targetClass="\Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption", field="id", targetField="consignment_id", from="result", auto=true)
     */
    protected $selectedShippingOption;

    /**
     * @var \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingAddress|null
     * @BC\HasOne(name="shipping_address", targetClass="\Bigcommerce\ORM\Entities\CheckoutConsignmentShippingAddress", field="id", targetField="consignment_id", from="result", auto=true)
     */
    protected $shippingAddress;

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
    public function getSelectedShippingOption(): ?\Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption
    {
        return $this->selectedShippingOption;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption|null $selectedShippingOption
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     */
    public function setSelectedShippingOption(?\Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption $selectedShippingOption): CheckoutConsignment
    {
        $this->selectedShippingOption = $selectedShippingOption;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingAddress|null
     */
    public function getShippingAddress(): ?\Bigcommerce\ORM\Entities\CheckoutConsignmentShippingAddress
    {
        return $this->shippingAddress;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingAddress|null $shippingAddress
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment
     */
    public function setShippingAddress(?\Bigcommerce\ORM\Entities\CheckoutConsignmentShippingAddress $shippingAddress): CheckoutConsignment
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }
}