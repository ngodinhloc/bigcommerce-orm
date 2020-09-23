<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ProductVariant
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductVariant", path="/catalog/products/{product_id}/variants", type="api")
 */
class ProductVariant extends AbstractEntity
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", pathParam=true)
     */
    protected $productId;

    /**
     * @var int|null
     * @BC\Field(name="sku_id")
     */
    protected $skuId;

    /**
     * @var string|null
     * @BC\Field(name="sku")
     */
    protected $sku;

    /**
     * @var float|null
     * @BC\Field(name="weight")
     */
    protected $weight;

    /**
     * @var float|null
     * @BC\Field(name="weight")
     */
    protected $calculatedWeight;

    /**
     * @var float|null
     * @BC\Field(name="width")
     */
    protected $width;

    /**
     * @var float|null
     * @BC\Field(name="depth")
     */
    protected $depth;

    /**
     * @var float|null
     * @BC\Field(name="height")
     */
    protected $height;

    /**
     * @var float|null
     * @BC\Field(name="price")
     */
    protected $price;

    /**
     * @var float|null
     * @BC\Field(name="calculated_price")
     */
    protected $calculatedPrice;

    /**
     * @var float|null
     * @BC\Field(name="cost_price")
     */
    protected $costPrice;

    /**
     * @var float|null
     * @BC\Field(name="sale_price")
     */
    protected $salePrice;

    /**
     * @var float|null
     * @BC\Field(name="retail_price")
     */
    protected $retailPrice;

    /**
     * @var float|null
     * @BC\Field(name="map_price")
     */
    protected $mapPrice;

    /**
     * @var bool
     * @BC\Field(name="is_free_shipping")
     */
    protected $isFreeShipping;

    /**
     * @var float|null
     * @BC\Field(name="fixed_cost_shipping_price")
     */
    protected $fixedCostShippingPrice;

    /**
     * @var bool
     * @BC\Field(name="purchasing_disabled")
     */
    protected $purchasingDisabled;

    /**
     * @var string|null
     * @BC\Field(name="purchasing_disabled_message")
     */
    protected $purchasingDisabledMessage;

    /**
     * @var string|null
     * @BC\Field(name="image_url")
     */
    protected $imageUrl;

    /**
     * @var string|null
     * @BC\Field(name="upc")
     */
    protected $upc;

    /**
     * @var string|null
     * @BC\Field(name="mpn")
     */
    protected $mpn;

    /**
     * @var string|null
     * @BC\Field(name="gtin")
     */
    protected $gtin;

    /**
     * @var int|null
     * @BC\Field(name="inventory_level")
     */
    protected $inventoryLevel;

    /**
     * @var int|null
     * @BC\Field(name="inventory_warning_level")
     */
    protected $inventoryWarningLevel;

    /**
     * @var string|null
     * @BC\Field(name="bin_picking_number")
     */
    protected $binPickingNumber;

    /**
     * @var array|null
     * @BC\Field(name="option_values")
     */
    protected $optionValues;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setProductId(?int $productId): ProductVariant
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSkuId(): ?int
    {
        return $this->skuId;
    }

    /**
     * @param int|null $skuId
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setSkuId(?int $skuId): ProductVariant
    {
        $this->skuId = $skuId;

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
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setSku(?string $sku): ProductVariant
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getWeight(): ?float
    {
        return $this->weight;
    }

    /**
     * @param float|null $weight
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setWeight(?float $weight): ProductVariant
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getCalculatedWeight(): ?float
    {
        return $this->calculatedWeight;
    }

    /**
     * @param float|null $calculatedWeight
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setCalculatedWeight(?float $calculatedWeight): ProductVariant
    {
        $this->calculatedWeight = $calculatedWeight;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getWidth(): ?float
    {
        return $this->width;
    }

    /**
     * @param float|null $width
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setWidth(?float $width): ProductVariant
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getDepth(): ?float
    {
        return $this->depth;
    }

    /**
     * @param float|null $depth
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setDepth(?float $depth): ProductVariant
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getHeight(): ?float
    {
        return $this->height;
    }

    /**
     * @param float|null $height
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setHeight(?float $height): ProductVariant
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setPrice(?float $price): ProductVariant
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getCalculatedPrice(): ?float
    {
        return $this->calculatedPrice;
    }

    /**
     * @param float|null $calculatedPrice
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setCalculatedPrice(?float $calculatedPrice): ProductVariant
    {
        $this->calculatedPrice = $calculatedPrice;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getCostPrice(): ?float
    {
        return $this->costPrice;
    }

    /**
     * @param float|null $costPrice
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setCostPrice(?float $costPrice): ProductVariant
    {
        $this->costPrice = $costPrice;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getSalePrice(): ?float
    {
        return $this->salePrice;
    }

    /**
     * @param float|null $salePrice
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setSalePrice(?float $salePrice): ProductVariant
    {
        $this->salePrice = $salePrice;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getRetailPrice(): ?float
    {
        return $this->retailPrice;
    }

    /**
     * @param float|null $retailPrice
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setRetailPrice(?float $retailPrice): ProductVariant
    {
        $this->retailPrice = $retailPrice;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMapPrice(): ?float
    {
        return $this->mapPrice;
    }

    /**
     * @param float|null $mapPrice
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setMapPrice(?float $mapPrice): ProductVariant
    {
        $this->mapPrice = $mapPrice;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFreeShipping(): bool
    {
        return $this->isFreeShipping;
    }

    /**
     * @param bool $isFreeShipping
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setIsFreeShipping(bool $isFreeShipping): ProductVariant
    {
        $this->isFreeShipping = $isFreeShipping;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getFixedCostShippingPrice(): ?float
    {
        return $this->fixedCostShippingPrice;
    }

    /**
     * @param float|null $fixedCostShippingPrice
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setFixedCostShippingPrice(?float $fixedCostShippingPrice): ProductVariant
    {
        $this->fixedCostShippingPrice = $fixedCostShippingPrice;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPurchasingDisabled(): bool
    {
        return $this->purchasingDisabled;
    }

    /**
     * @param bool $purchasingDisabled
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setPurchasingDisabled(bool $purchasingDisabled): ProductVariant
    {
        $this->purchasingDisabled = $purchasingDisabled;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPurchasingDisabledMessage(): ?string
    {
        return $this->purchasingDisabledMessage;
    }

    /**
     * @param string|null $purchasingDisabledMessage
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setPurchasingDisabledMessage(?string $purchasingDisabledMessage): ProductVariant
    {
        $this->purchasingDisabledMessage = $purchasingDisabledMessage;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @param string|null $imageUrl
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setImageUrl(?string $imageUrl): ProductVariant
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUpc(): ?string
    {
        return $this->upc;
    }

    /**
     * @param string|null $upc
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setUpc(?string $upc): ProductVariant
    {
        $this->upc = $upc;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMpn(): ?string
    {
        return $this->mpn;
    }

    /**
     * @param string|null $mpn
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setMpn(?string $mpn): ProductVariant
    {
        $this->mpn = $mpn;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGtin(): ?string
    {
        return $this->gtin;
    }

    /**
     * @param string|null $gtin
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setGtin(?string $gtin): ProductVariant
    {
        $this->gtin = $gtin;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getInventoryLevel(): ?int
    {
        return $this->inventoryLevel;
    }

    /**
     * @param int|null $inventoryLevel
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setInventoryLevel(?int $inventoryLevel): ProductVariant
    {
        $this->inventoryLevel = $inventoryLevel;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getInventoryWarningLevel(): ?int
    {
        return $this->inventoryWarningLevel;
    }

    /**
     * @param int|null $inventoryWarningLevel
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setInventoryWarningLevel(?int $inventoryWarningLevel): ProductVariant
    {
        $this->inventoryWarningLevel = $inventoryWarningLevel;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBinPickingNumber(): ?string
    {
        return $this->binPickingNumber;
    }

    /**
     * @param string|null $binPickingNumber
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setBinPickingNumber(?string $binPickingNumber): ProductVariant
    {
        $this->binPickingNumber = $binPickingNumber;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getOptionValues(): ?array
    {
        return $this->optionValues;
    }

    /**
     * @param array|null $optionValues
     * @return \Bigcommerce\ORM\Entities\ProductVariant
     */
    public function setOptionValues(?array $optionValues): ProductVariant
    {
        $this->optionValues = $optionValues;

        return $this;
    }
}