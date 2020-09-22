<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;
use Bigcommerce\ORM\Mapper;

/**
 * Class CartItem
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Cart", path="/carts/{cart_id}/items", type="api")
 */
class CartItem extends Entity
{
    /**
     * @var string|null
     * @BC\Field(name="cart_id", readonly=true, pathParam=true)
     */
    protected $cartId;

    /**
     * @var array|null
     * @BC\Field(name="line_items")
     */
    protected $lineItems;

    /**
     * @var array|null
     * @BC\Field(name="gift_certificates")
     */
    protected $giftCertificates;

    /**
     * @var array|null
     * @BC\Field(name="custom_items")
     */
    protected $customItems;

    /** @var \Bigcommerce\ORM\Mapper */
    private $mapper;

    /**
     * CartItem constructor.
     */
    public function __construct()
    {
        $this->mapper = new Mapper();
    }

    /**
     * @return string|null
     */
    public function getCartId(): ?string
    {
        return $this->cartId;
    }

    /**
     * @param string|null $cartId
     * @return \Bigcommerce\ORM\Entities\CartItem
     */
    public function setCartId(?string $cartId): CartItem
    {
        $this->cartId = $cartId;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CartLineItem[]|null
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getLineItems()
    {
        if (empty($this->lineItems)) {
            return null;
        }

        return $this->mapper->arrayToCollection($this->lineItems, CartLineItem::class, ['cart_id' => $this->cartId]);
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CartLineItem|null $item
     * @return \Bigcommerce\ORM\Entities\CartItem
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function addLineItem(?CartLineItem $item)
    {
        $data = $this->mapper->getWritableFieldValues($item);
        $this->lineItems[] = $data;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CartGiftCertificate[]|null
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getGiftCertificates()
    {
        if (empty($this->giftCertificates)) {
            return null;
        }

        return $this->mapper->arrayToCollection($this->giftCertificates, CartGiftCertificate::class, ['cart_id' => $this->cartId]);
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CartGiftCertificate|null $gift
     * @return \Bigcommerce\ORM\Entities\CartItem
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function addGiftCertificate(?CartGiftCertificate $gift)
    {
        $data = $this->mapper->getWritableFieldValues($gift);
        $this->giftCertificates[] = $data;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CartCustomItem[]|null
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getCustomItems()
    {
        if (empty($this->customItems)) {
            return null;
        }

        return $this->mapper->arrayToCollection($this->customItems, CartCustomItem::class, ['cart_id' => $this->cartId]);
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CartCustomItem|null $item
     * @return \Bigcommerce\ORM\Entities\CartItem
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function addCustomItem(?CartCustomItem $item)
    {
        $data = $this->mapper->getWritableFieldValues($item);
        $this->customItems[] = $data;

        return $this;
    }
}