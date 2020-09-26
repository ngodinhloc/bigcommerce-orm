<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CustomItem
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CustomItem")
 */
class CustomItem extends AbstractEntity
{
    /**
     * @var string|null
     * @BC\Field(name="cart_id", readonly=true)
     */
    protected $cartId;

    /**
     * @var string|null
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var string|null
     * @BC\Field(name="sku")
     */
    protected $sku;

    /**
     * @var int|null
     * @BC\Field(name="quantity")
     */
    protected $quantity;

    /**
     * @var float|null
     * @BC\Field(name="list_price")
     */
    protected $listPrice;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\CustomItem
     */
    public function setName(?string $name): CustomItem
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @param string|null $sku
     * @return \Bigcommerce\ORM\Entities\CustomItem
     */
    public function setSku(?string $sku): CustomItem
    {
        $this->sku = $sku;

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
     * @return \Bigcommerce\ORM\Entities\CustomItem
     */
    public function setQuantity(?int $quantity): CustomItem
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
     * @return \Bigcommerce\ORM\Entities\CustomItem
     */
    public function setListPrice(?float $listPrice): CustomItem
    {
        $this->listPrice = $listPrice;

        return $this;
    }
}