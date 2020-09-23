<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ProductVideo
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductVideo", path="/catalog/products/{product_id}/videos", type="api")
 */
class ProductVideo extends AbstractVideo
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", pathParam=true)
     */
    protected $productId;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductVideo
     */
    public function setProductId(?int $productId): ProductVideo
    {
        $this->productId = $productId;

        return $this;
    }
}