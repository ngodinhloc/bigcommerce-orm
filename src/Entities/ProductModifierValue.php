<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ProductModifierValue
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductModifierValue", path="/catalog/products/{product_id}/modifiers/{option_id}/values", type="api")
 */
class ProductModifierValue extends AbstractOptionValue
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
     * @var array|null
     * @BC\Field(name="adjusters")
     */
    protected $adjusters;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setProductId(?int $productId): ProductModifierValue
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
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setModifierId(?int $modifierId): ProductModifierValue
    {
        $this->modifierId = $modifierId;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getAdjusters(): ?array
    {
        return $this->adjusters;
    }

    /**
     * @param array|null $adjusters
     * @return \Bigcommerce\ORM\Entities\ProductModifierValue
     */
    public function setAdjusters(?array $adjusters): ProductModifierValue
    {
        $this->adjusters = $adjusters;

        return $this;
    }
}