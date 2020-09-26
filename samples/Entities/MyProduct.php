<?php
declare(strict_types=1);

namespace Samples\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class MyProduct
 * @package Samples\Entities
 * @BC\Resource(name="Product", path="/catalog/products")
 */
class MyProduct extends AbstractEntity
{

    /**
     * @var string
     * @BC\Field(name="my_customised_field", customised=true, readonly=true)
     */
    protected $myCustomisedField;

    /**
     * @var string
     * @BC\Field(name="email", required=true)
     * @BC\Email(validate=true)
     */
    protected $email;

    /**
     * @var string
     * @BC\Field(name="date_created", readonly=true)
     * @BC\Date(format="Y-m-d")
     */
    protected $dateCreated;

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
    public function getMyCustomisedField(): string
    {
        return $this->myCustomisedField;
    }

    /**
     * @param string $myCustomisedField
     * @return \Samples\Entities\MyProduct
     */
    public function setMyCustomisedField(string $myCustomisedField): MyProduct
    {
        $this->myCustomisedField = $myCustomisedField;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return \Samples\Entities\MyProduct
     */
    public function setEmail(string $email): MyProduct
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateCreated(): string
    {
        return $this->dateCreated;
    }

    /**
     * @param string $dateCreated
     * @return \Samples\Entities\MyProduct
     */
    public function setDateCreated(string $dateCreated): MyProduct
    {
        $this->dateCreated = $dateCreated;

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
     * @return \Samples\Entities\MyProduct
     */
    public function setPrimaryImage(\Bigcommerce\ORM\Entities\ProductImage $primaryImage): MyProduct
    {
        $this->primaryImage = $primaryImage;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductImage[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductImage[] $images
     * @return \Samples\Entities\MyProduct
     */
    public function setImages(array $images): MyProduct
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\Category[] $categories
     * @return \Samples\Entities\MyProduct
     */
    public function setCategories(array $categories): MyProduct
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductReview[]
     */
    public function getReviews(): array
    {
        return $this->reviews;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductReview[] $reviews
     * @return \Samples\Entities\MyProduct
     */
    public function setReviews(array $reviews): MyProduct
    {
        $this->reviews = $reviews;

        return $this;
    }
}