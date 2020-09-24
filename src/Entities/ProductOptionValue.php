<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ProductOptionValue
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductOptionValue", path="/catalog/products/{product_id}/options/{option_id}/values", type="api")
 */
class ProductOptionValue extends AbstractOptionValue
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
    protected $optionId;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductOptionValue
     */
    public function setProductId(?int $productId): ProductOptionValue
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getOptionId(): ?int
    {
        return $this->optionId;
    }

    /**
     * @param int|null $optionId
     * @return \Bigcommerce\ORM\Entities\ProductOptionValue
     */
    public function setOptionId(?int $optionId): ProductOptionValue
    {
        $this->optionId = $optionId;

        return $this;
    }
}