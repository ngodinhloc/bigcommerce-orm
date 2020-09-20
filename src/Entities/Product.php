<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class Product
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Product", path="/catalog/products")
 */
class Product extends Entity
{
    /**
     * @var string|null
     * @BC\Field(name="name", required=true)
     */
    protected $name;

    /**
     * @var string|null
     * @BC\Field(name="type")
     */
    protected $type;

    /**
     * @var string|null
     * @BC\Field(name="sku")
     */
    protected $sku;

    /**
     * @var string|null
     * @BC\Field(name="description")
     */
    protected $description;

    /**
     * @var float|null
     * @BC\Field(name="weight")
     */
    protected $weight;

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
     * @var int|null
     * @BC\Field(name="brand_id")
     */
    protected $brandId;

    /**
     * @var array|null
     * @BC\Field(name="categories")
     */
    protected $categoryIds;

    /**
     * @var string|null
     * @BC\Field(name="date_created", readonly=true)
     * @BC\Date()
     */
    protected $dateCreated;

    /**
     * @var string|null
     * @BC\Field(name="date_modified", readonly=true)
     * @BC\Date()
     */
    protected $dateModified;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductImage|null
     * @BC\HasOne(name="primary_image", targetClass="\Bigcommerce\ORM\Entities\ProductImage", field="id", targetField="product_id", from="include", auto=true)
     */
    protected $primaryImage;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductImage[]|null
     * @BC\HasMany(name="images", targetClass="\Bigcommerce\ORM\Entities\ProductImage", field="id", targetField="product_id", from="include", auto=true)
     */
    protected $images;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductVariant[]|null
     * @BC\HasMany(name="variants", targetClass="\Bigcommerce\ORM\Entities\ProductVariant", field="id", targetField="product_id", from="include", auto=true)
     */
    protected $variants;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductCustomField[]|null
     * @BC\HasMany(name="custom_fields", targetClass="\Bigcommerce\ORM\Entities\ProductCustomField", field="id", targetField="product_id", from="include", auto=true)
     */
    protected $customFields;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductBulkPriceRule[]|null
     * @BC\HasMany(name="custom_fields", targetClass="\Bigcommerce\ORM\Entities\ProductBulkPriceRule", field="id", targetField="product_id", from="include", auto=true)
     */
    protected $bulkPricingRules;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductModifier[]|null
     * @BC\HasMany(name="modifiers", targetClass="\Bigcommerce\ORM\Entities\ProductModifier", field="id", targetField="product_id", from="include", auto=true)
     */
    protected $modifiers;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductOption[]|null
     * @BC\HasMany(name="options", targetClass="\Bigcommerce\ORM\Entities\ProductOption", field="id", targetField="product_id", from="include", auto=true)
     */
    protected $options;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductVideo[]|null
     * @BC\HasMany(name="videos", targetClass="\Bigcommerce\ORM\Entities\ProductVideo", field="id", targetField="product_id", from="include", auto=true)
     */
    protected $videos;

    /**
     * @var \Bigcommerce\ORM\Entities\Category[]|null
     * @BC\BelongToMany(name="categories", targetClass="\Bigcommerce\ORM\Entities\Category", field="categories", targetField="id", from="api", auto=true)
     */
    protected $categories;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductReview[]|null
     * @BC\HasMany(name="reviews", targetClass="\Bigcommerce\ORM\Entities\ProductReview", field="id", targetField="product_id", from="api", auto=true)
     */
    protected $reviews;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setName(?string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setType(?string $type): Product
    {
        $this->type = $type;
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
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setSku(?string $sku): Product
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setDescription(?string $description): Product
    {
        $this->description = $description;
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
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setWeight(?float $weight): Product
    {
        $this->weight = $weight;
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
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setWidth(?float $width): Product
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
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setDepth(?float $depth): Product
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
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setHeight(?float $height): Product
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
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setPrice(?float $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getBrandId(): ?int
    {
        return $this->brandId;
    }

    /**
     * @param int|null $brandId
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setBrandId(?int $brandId): Product
    {
        $this->brandId = $brandId;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getCategoryIds(): ?array
    {
        return $this->categoryIds;
    }

    /**
     * @param array|null $categoryIds
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setCategoryIds(?array $categoryIds): Product
    {
        $this->categoryIds = $categoryIds;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateCreated(): ?string
    {
        return $this->dateCreated;
    }

    /**
     * @param string|null $dateCreated
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setDateCreated(?string $dateCreated): Product
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateModified(): ?string
    {
        return $this->dateModified;
    }

    /**
     * @param string|null $dateModified
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setDateModified(?string $dateModified): Product
    {
        $this->dateModified = $dateModified;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductImage|null
     */
    public function getPrimaryImage(): ?\Bigcommerce\ORM\Entities\ProductImage
    {
        return $this->primaryImage;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductImage|null $primaryImage
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setPrimaryImage(?\Bigcommerce\ORM\Entities\ProductImage $primaryImage): Product
    {
        $this->primaryImage = $primaryImage;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductImage[]|null
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductImage[]|null $images
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setImages(?array $images): Product
    {
        $this->images = $images;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\Category[]|null
     */
    public function getCategories(): ?array
    {
        return $this->categories;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\Category[]|null $categories
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setCategories(?array $categories): Product
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductReview[]|null
     */
    public function getReviews(): ?array
    {
        return $this->reviews;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductReview[]|null $reviews
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setReviews(?array $reviews): Product
    {
        $this->reviews = $reviews;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductVariant[]|null
     */
    public function getVariants(): ?array
    {
        return $this->variants;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductVariant[]|null $variants
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setVariants(?array $variants): Product
    {
        $this->variants = $variants;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductCustomField[]|null
     */
    public function getCustomFields(): ?array
    {
        return $this->customFields;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductCustomField[]|null $customFields
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setCustomFields(?array $customFields): Product
    {
        $this->customFields = $customFields;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductBulkPriceRule[]|null
     */
    public function getBulkPricingRules(): ?array
    {
        return $this->bulkPricingRules;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductBulkPriceRule[]|null $bulkPricingRules
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setBulkPricingRules(?array $bulkPricingRules): Product
    {
        $this->bulkPricingRules = $bulkPricingRules;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductModifier[]|null
     */
    public function getModifiers(): ?array
    {
        return $this->modifiers;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductModifier[]|null $modifiers
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setModifiers(?array $modifiers): Product
    {
        $this->modifiers = $modifiers;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductOption[]|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductOption[]|null $options
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setOptions(?array $options): Product
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductVideo[]|null
     */
    public function getVideos(): ?array
    {
        return $this->videos;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductVideo[]|null $videos
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setVideos(?array $videos): Product
    {
        $this->videos = $videos;
        return $this;
    }
}