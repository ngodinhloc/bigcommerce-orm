<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ProductMetafield
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductMetafield", path="/catalog/products/{product_id}/metafields", type="api")
 */
class ProductMetafield extends AbstractMetafield
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var string|null
     * @BC\Field(name="created_at")
     */
    protected $dateCreated;

    /**
     * @var string|null
     * @BC\Field(name="updated_at")
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
     * @return \Bigcommerce\ORM\Entities\ProductMetafield
     */
    public function setProductId(?int $productId): ProductMetafield
    {
        $this->productId = $productId;

        return $this;
    }
}