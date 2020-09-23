<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ProductModifierImage
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductModifierImage", path="/catalog/products/{product_id}/modifiers/{option_id}/image", type="api")
 */
class ProductModifierImage extends AbstractImage
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var int|null
     * @BC\Field(name="option_id", readonly=true, pathParam=true)
     */
    protected $modifierId;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductModifierImage
     */
    public function setProductId(?int $productId): ProductModifierImage
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getModifierId(): ?int
    {
        return $this->modifierId;
    }

    /**
     * @param int|null $modifierId
     * @return \Bigcommerce\ORM\Entities\ProductModifierImage
     */
    public function setModifierId(?int $modifierId): ProductModifierImage
    {
        $this->modifierId = $modifierId;

        return $this;
    }
}