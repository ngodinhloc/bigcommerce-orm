<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ProductVariantMetafield
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductVariantMetafield", path="/catalog/products/{product_id}/variants/{variant_id}/metafields", type="api")
 */
class ProductVariantMetafield extends AbstractMetafield
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var int|null
     * @BC\Field(name="variant_id", readonly=true, pathParam=true)
     */
    protected $variantId;

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
     * @return \Bigcommerce\ORM\Entities\ProductVariantMetafield
     */
    public function setProductId(?int $productId): ProductVariantMetafield
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getVariantId(): ?int
    {
        return $this->variantId;
    }

    /**
     * @param int|null $variantId
     * @return \Bigcommerce\ORM\Entities\ProductVariantMetafield
     */
    public function setVariantId(?int $variantId): ProductVariantMetafield
    {
        $this->variantId = $variantId;

        return $this;
    }
}