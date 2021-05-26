<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Mapper;

/**
 * Class CartItem
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Cart", path="/carts/{cart_id}/items", type="api")
 */
class CartItem extends AbstractEntity
{
    /**
     * @var string|null
     * @BC\Field(name="cart_id", readonly=true, pathParam=true)
     */
    protected $cartId;

    /**
     * @var array
     * @BC\Field(name="line_items")
     */
    protected $lineItems = [];

    /**
     * @var array
     * @BC\Field(name="gift_certificates")
     */
    protected $giftCertificates = [];

    /**
     * @var array
     * @BC\Field(name="custom_items")
     */
    protected $customItems = [];

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
     * @return \Bigcommerce\ORM\Entities\LineItem[]|null
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getLineItems()
    {
        if (empty($this->lineItems)) {
            return null;
        }

        return $this->mapper->arrayToCollection($this->lineItems, LineItem::class, ['cart_id' => $this->cartId]);
    }

    /**
     * @param \Bigcommerce\ORM\Entities\LineItem|null $item
     * @return \Bigcommerce\ORM\Entities\CartItem
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function addLineItem(?LineItem $item)
    {
        $data = $this->mapper->getWritableFieldValues($item);
        $this->lineItems[] = $data;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\GiftCertificate[]|null
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getGiftCertificates()
    {
        if (empty($this->giftCertificates)) {
            return null;
        }

        return $this->mapper->arrayToCollection($this->giftCertificates, GiftCertificate::class, ['cart_id' => $this->cartId]);
    }

    /**
     * @param \Bigcommerce\ORM\Entities\GiftCertificate|null $gift
     * @return \Bigcommerce\ORM\Entities\CartItem
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function addGiftCertificate(?GiftCertificate $gift)
    {
        $data = $this->mapper->getWritableFieldValues($gift);
        $this->giftCertificates[] = $data;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\CustomItem[]|null
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getCustomItems()
    {
        if (empty($this->customItems)) {
            return null;
        }

        return $this->mapper->arrayToCollection($this->customItems, CustomItem::class, ['cart_id' => $this->cartId]);
    }

    /**
     * @param \Bigcommerce\ORM\Entities\CustomItem|null $item
     * @return \Bigcommerce\ORM\Entities\CartItem
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function addCustomItem(?CustomItem $item)
    {
        $data = $this->mapper->getWritableFieldValues($item);
        $this->customItems[] = $data;

        return $this;
    }
}
