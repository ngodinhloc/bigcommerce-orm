<?php
declare(strict_types=1);

namespace Samples\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CustomisedOrderProduct
 * @package Samples\Entities
 * @BC\BigObject(name="Product", path="/catalog/products")
 */
class MyProduct extends Entity
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
     * @BC\HasOneTest(name="primary_image", targetClass="\Bigcommerce\ORM\Entities\ProductImage", field="id", targetField="product_id", include=true, auto=true)
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
     * @return MyProduct
     */
    public function setMyCustomisedField(string $myCustomisedField): MyProduct
    {
        $this->myCustomisedField = $myCustomisedField;
        return $this;
    }


}