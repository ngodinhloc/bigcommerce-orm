<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class Checkout
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Checkout", path="/checkouts", type="api", creatable=false, deletable=false, updatable=false)
 */
class Checkout extends AbstractEntity
{
    /**
     * @var array|null
     * @BC\Field(name="taxes", readonly=true)
     */
    protected $taxes;

    /**
     * @var string|int|null
     * @BC\Field(name="order_id", readonly=true)
     */
    protected $orderId;

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
     * @var float|null
     * @BC\Field(name="tax_total", readonly=true)
     */
    protected $taxTotal;

    /**
     * @var float|null
     * @BC\Field(name="subtotal_inc_tax", readonly=true)
     */
    protected $subtotalIncTax;

    /**
     * @var float|null
     * @BC\Field(name="subtotal_ex_tax", readonly=true)
     */
    protected $subtotalExTax;

    /**
     * @var float|null
     * @BC\Field(name="grand_total", readonly=true)
     */
    protected $grandTotal;

    /**
     * @var string|null
     * @BC\Field(name="customer_message", readonly=true)
     */
    protected $customerMessage;

    /**
     * @var string|null
     * @BC\Field(name="created_time", readonly=true)
     */
    protected $createdTime;

    /**
     * @var string|null
     * @BC\Field(name="updated_time", readonly=true)
     */
    protected $updatedTime;

    /**
     * @var \Bigcommerce\ORM\Entities\Cart|null
     * @BC\BelongToOne(name="cart", targetClass="\Bigcommerce\ORM\Entities\Cart", field="id", targetField="checkout_id", from="result", auto=true)
     */
    protected $cart;

    /**
     * @var \Bigcommerce\ORM\Entities\CheckoutBillingAddress|null
     * @BC\HasOne(name="billing_address", targetClass="\Bigcommerce\ORM\Entities\CheckoutBillingAddress", field="id", targetField="checkout_id", from="result", auto=true)
     */
    protected $billingAddress;

    /**
     * @var \Bigcommerce\ORM\Entities\CheckoutConsignment[]|null
     * @BC\HasMany(name="consignments", targetClass="\Bigcommerce\ORM\Entities\CheckoutConsignment", field="id", targetField="checkout_id", from="result", auto=true)
     */
    protected $consignments;

    /**
     * @var \Bigcommerce\ORM\Entities\CheckoutCoupon[]|null
     * @BC\HasMany(name="coupons", targetClass="\Bigcommerce\ORM\Entities\CheckoutCoupon", field="id", targetField="checkout_id", from="result", auto=true)
     */
    protected $coupons;

    /**
     * @return array|null
     */
    public function getTaxes(): ?array
    {
        return $this->taxes;
    }

    /**
     * @param array|null $taxes
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setTaxes(?array $taxes): Checkout
    {
        $this->taxes = $taxes;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CheckoutCoupon[]|null
     */
    public function getCoupons(): ?array
    {
        return $this->coupons;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CheckoutCoupon[]|null $coupons
     * @return Checkout
     */
    public function setCoupons(?array $coupons): Checkout
    {
        $this->coupons = $coupons;

        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int|string|null $orderId
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
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
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setShippingCostTotalIncTax(?float $shippingCostTotalIncTax): Checkout
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
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setShippingCostTotalExTax(?float $shippingCostTotalExTax): Checkout
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
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setHandlingCostTotalIncTax(?float $handlingCostTotalIncTax): Checkout
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
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setHandlingCostTotalExTax(?float $handlingCostTotalExTax): Checkout
    {
        $this->handlingCostTotalExTax = $handlingCostTotalExTax;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTaxTotal(): ?float
    {
        return $this->taxTotal;
    }

    /**
     * @param float|null $taxTotal
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setTaxTotal(?float $taxTotal): Checkout
    {
        $this->taxTotal = $taxTotal;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getSubtotalIncTax(): ?float
    {
        return $this->subtotalIncTax;
    }

    /**
     * @param float|null $subtotalIncTax
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setSubtotalIncTax(?float $subtotalIncTax): Checkout
    {
        $this->subtotalIncTax = $subtotalIncTax;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getSubtotalExTax(): ?float
    {
        return $this->subtotalExTax;
    }

    /**
     * @param float|null $subtotalExTax
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setSubtotalExTax(?float $subtotalExTax): Checkout
    {
        $this->subtotalExTax = $subtotalExTax;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getGrandTotal(): ?float
    {
        return $this->grandTotal;
    }

    /**
     * @param float|null $grandTotal
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setGrandTotal(?float $grandTotal): Checkout
    {
        $this->grandTotal = $grandTotal;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerMessage(): ?string
    {
        return $this->customerMessage;
    }

    /**
     * @param string|null $customerMessage
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setCustomerMessage(?string $customerMessage): Checkout
    {
        $this->customerMessage = $customerMessage;

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
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setCreatedTime(?string $createdTime): Checkout
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
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setUpdatedTime(?string $updatedTime): Checkout
    {
        $this->updatedTime = $updatedTime;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\Cart|null
     */
    public function getCart(): ?\Bigcommerce\ORM\Entities\Cart
    {
        return $this->cart;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\Cart|null $cart
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setCart(?\Bigcommerce\ORM\Entities\Cart $cart): Checkout
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CheckoutBillingAddress|null
     */
    public function getBillingAddress(): ?CheckoutBillingAddress
    {
        return $this->billingAddress;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CheckoutBillingAddress|null $billingAddress
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setBillingAddress(?CheckoutBillingAddress $billingAddress): Checkout
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignment[]|null
     */
    public function getConsignments(): ?array
    {
        return $this->consignments;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CheckoutConsignment[]|null $consignments
     * @return \Bigcommerce\ORM\Entities\Checkout
     */
    public function setConsignments(?array $consignments): Checkout
    {
        $this->consignments = $consignments;

        return $this;
    }
}