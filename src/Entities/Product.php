<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class Product
 * @package Bigcommerce\ORM\Entities
 * @BC\BigObject(name="Product", path="/catalog/products")
 */
class Product extends Entity
{
    /**
     * @var string
     * @BC\Field(name="name", required=true)
     */
    protected $name;

    /**
     * @var string
     * @BC\Field(name="type")
     */
    protected $type;

    /**
     * @var string
     * @BC\Field(name="sku")
     */
    protected $sku;

    /**
     * @var string
     * @BC\Field(name="description")
     */
    protected $description;

    /**
     * @var float
     * @BC\Field(name="weight")
     */
    protected $weight;

    /**
     * @var float
     * @BC\Field(name="width")
     */
    protected $width;

    /**
     * @var float
     * @BC\Field(name="depth")
     */
    protected $depth;

    /**
     * @var float
     * @BC\Field(name="height")
     */
    protected $height;

    /**
     * @var float
     * @BC\Field(name="price")
     */
    protected $price;

    /**
     * @var int
     * @BC\Field(name="brand_id")
     */
    protected $brandId;

    /**
     * @var array
     * @BC\Field(name="categories")
     */
    protected $categoryIds;

    /**
     * @var string
     * @BC\Field(name="date_created", readonly=true)
     * @BC\Date()
     */
    protected $dateCreated;

    /**
     * @var string
     * @BC\Field(name="date_modified", readonly=true)
     * @BC\Date()
     */
    protected $dateModified;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductImage
     * @BC\HasOne(name="primary_image", targetClass="\Bigcommerce\ORM\Entities\ProductImage", field="id", targetField="product_id", include=true, auto=true)
     */
    protected $primaryImage;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductImage[]
     * @BC\HasMany(name="images", targetClass="\Bigcommerce\ORM\Entities\ProductImage", field="id", targetField="product_id", include=true, auto=true)
     */
    protected $images;

    /**
     * @var \Bigcommerce\ORM\Entities\Category[]
     * @BC\BelongToMany(name="categories", targetClass="\Bigcommerce\ORM\Entities\Category", field="categories", targetField="id", auto=true)
     */
    protected $categories;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductReview[]
     * @BC\HasMany (name="reviews", targetClass="\Bigcommerce\ORM\Entities\ProductReview", field="id", targetField="product_id", auto=true)
     */
    protected $reviews;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setType(string $type): Product
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setSku(string $sku): Product
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setDescription(string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setWeight(float $weight): Product
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param float $width
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setWidth(float $width): Product
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return float
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param float $depth
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setDepth(float $depth): Product
    {
        $this->depth = $depth;
        return $this;
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param float $height
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setHeight(float $height): Product
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getBrandId()
    {
        return $this->brandId;
    }

    /**
     * @param int $brandId
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setBrandId(int $brandId): Product
    {
        $this->brandId = $brandId;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param string $dateCreated
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setDateCreated(string $dateCreated): Product
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * @param string $dateModified
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setDateModified(string $dateModified): Product
    {
        $this->dateModified = $dateModified;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function getPrimaryImage(): \Bigcommerce\ORM\Entities\ProductImage
    {
        return $this->primaryImage;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductImage $primaryImage
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setPrimaryImage(\Bigcommerce\ORM\Entities\ProductImage $primaryImage): Product
    {
        $this->primaryImage = $primaryImage;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductImage[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductImage[] $images
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setImages(array $images): Product
    {
        $this->images = $images;
        return $this;
    }

    /**
     * @return array
     */
    public function getCategoryIds()
    {
        return $this->categoryIds;
    }

    /**
     * @param array $categoryIds
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setCategoryIds(array $categoryIds): Product
    {
        $this->categoryIds = $categoryIds;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\Category[] $categories
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setCategories(array $categories): Product
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductReview[]
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductReview[] $reviews
     * @return \Bigcommerce\ORM\Entities\Product
     */
    public function setReviews(array $reviews): Product
    {
        $this->reviews = $reviews;
        return $this;
    }
}