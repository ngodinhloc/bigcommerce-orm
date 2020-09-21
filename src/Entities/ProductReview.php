<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class ProductReview
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductImage", path="/catalog/products/{product_id}/reviews", type="api")
 */
class ProductReview extends Entity
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var string|null
     * @BC\Field(name="title")
     */
    protected $title;

    /**
     * @var string|null
     * @BC\Field(name="text")
     */
    protected $text;

    /**
     * @var string|null
     * @BC\Field(name="status")
     */
    protected $status;

    /**
     * @var int|null
     * @BC\Field(name="rating")
     */
    protected $rating;

    /**
     * @var string|null
     * @BC\Field(name="email")
     * @BC\Email(validate=true)
     */
    protected $email;

    /**
     * @var string|null
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var string|null
     * @BC\Field(name="date_reviewed")
     * @BC\Date
     */
    protected $dateReviewed;

    /**
     * @var string|null
     * @BC\Field(name="date_created", readonly=true)
     * @BC\Date
     */
    protected $dateCreated;

    /**
     * @var string|null
     * @BC\Field(name="date_modified", readonly=true)
     * @BC\Date
     */
    protected $dateModified;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setProductId(?int $productId): ProductReview
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setTitle(?string $title): ProductReview
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setText(?string $text): ProductReview
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setStatus(?string $status): ProductReview
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }

    /**
     * @param int|null $rating
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setRating(?int $rating): ProductReview
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setEmail(?string $email): ProductReview
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setName(?string $name): ProductReview
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateReviewed(): ?string
    {
        return $this->dateReviewed;
    }

    /**
     * @param string|null $dateReviewed
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setDateReviewed(?string $dateReviewed): ProductReview
    {
        $this->dateReviewed = $dateReviewed;
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
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setDateCreated(?string $dateCreated): ProductReview
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
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setDateModified(?string $dateModified): ProductReview
    {
        $this->dateModified = $dateModified;
        return $this;
    }
}