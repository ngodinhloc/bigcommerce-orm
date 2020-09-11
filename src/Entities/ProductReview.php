<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class ProductReview
 * @package Bigcommerce\ORM\Entities
 * @BC\BigObject(name="ProductImage", path="/catalog/products/{id}/reviews", parentField="product_id")
 */
class ProductReview extends Entity
{
    /**
     * @var int
     * @BC\Field(name="product_id", readonly=true)
     */
    protected $productId;

    /**
     * @var string
     * @BC\Field(name="title")
     */
    protected $title;

    /**
     * @var string
     * @BC\Field(name="text")
     */
    protected $text;

    /**
     * @var string
     * @BC\Field(name="status")
     */
    protected $status;

    /**
     * @var int
     * @BC\Field(name="rating")
     */
    protected $rating;

    /**
     * @var string
     * @BC\Field(name="email")
     * @BC\Email(validate=true)
     */
    protected $email;

    /**
     * @var string
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var string
     * @BC\Field(name="date_reviewed")
     * @BC\Date
     */
    protected $dateReviewed;

    /**
     * @var string
     * @BC\Field(name="date_created", readonly=true)
     * @BC\Date
     */
    protected $dateCreated;

    /**
     * @var string
     * @BC\Field(name="date_modified", readonly=true)
     * @BC\Date
     */
    protected $dateModified;

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setProductId(int $productId): ProductReview
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setTitle(string $title): ProductReview
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setText(string $text): ProductReview
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setStatus(string $status): ProductReview
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setRating(int $rating): ProductReview
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setEmail(string $email): ProductReview
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setName(string $name): ProductReview
    {
        $this->name = $name;
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
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setDateCreated(string $dateCreated): ProductReview
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
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setDateModified(string $dateModified): ProductReview
    {
        $this->dateModified = $dateModified;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateReviewed()
    {
        return $this->dateReviewed;
    }

    /**
     * @param string $dateReviewed
     * @return \Bigcommerce\ORM\Entities\ProductReview
     */
    public function setDateReviewed(string $dateReviewed): ProductReview
    {
        $this->dateReviewed = $dateReviewed;
        return $this;
    }

}