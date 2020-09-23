<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CartRedirectUrl
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CartRedirectUrl", path="/carts/{cart_id}/redirect_urls", type="api", findable=false, deletable=false, updatable=false)
 */
class CartRedirectUrl extends AbstractEntity
{
    /**
     * @var string|null
     * @BC\Field(name="cart_id", pathParam=true)
     */
    protected $cartId;

    /**
     * @var string|null
     * @BC\Field(name="cart_url")
     */
    protected $cartUrl;

    /**
     * @var string|null
     * @BC\Field(name="checkout_url")
     */
    protected $checkoutUrl;

    /**
     * @var string|null
     * @BC\Field(name="embedded_checkout_url")
     */
    protected $embeddedCheckoutUrl;

    /**
     * @return string|null
     */
    public function getCartId(): ?string
    {
        return $this->cartId;
    }

    /**
     * @param string|null $cartId
     * @return \Bigcommerce\ORM\Entities\CartRedirectUrl
     */
    public function setCartId(?string $cartId): CartRedirectUrl
    {
        $this->cartId = $cartId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCartUrl(): ?string
    {
        return $this->cartUrl;
    }

    /**
     * @param string|null $cartUrl
     * @return \Bigcommerce\ORM\Entities\CartRedirectUrl
     */
    public function setCartUrl(?string $cartUrl): CartRedirectUrl
    {
        $this->cartUrl = $cartUrl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCheckoutUrl(): ?string
    {
        return $this->checkoutUrl;
    }

    /**
     * @param string|null $checkoutUrl
     * @return \Bigcommerce\ORM\Entities\CartRedirectUrl
     */
    public function setCheckoutUrl(?string $checkoutUrl): CartRedirectUrl
    {
        $this->checkoutUrl = $checkoutUrl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmbeddedCheckoutUrl(): ?string
    {
        return $this->embeddedCheckoutUrl;
    }

    /**
     * @param string|null $embeddedCheckoutUrl
     * @return \Bigcommerce\ORM\Entities\CartRedirectUrl
     */
    public function setEmbeddedCheckoutUrl(?string $embeddedCheckoutUrl): CartRedirectUrl
    {
        $this->embeddedCheckoutUrl = $embeddedCheckoutUrl;

        return $this;
    }
}