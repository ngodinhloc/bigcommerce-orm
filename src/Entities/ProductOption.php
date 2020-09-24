<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ProductOption
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductOption", path="/catalog/products/{product_id}/options", type="api")
 */
class ProductOption extends AbstractOption
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductOptionValue[]|null
     * @BC\HasMany(name="option_values", targetClass="\Bigcommerce\ORM\Entities\ProductOptionValue", field="id", targetField="option_id", from="result", auto=true)
     */
    protected $optionValues;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductOption
     */
    public function setProductId(?int $productId): ProductOption
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\ProductOptionValue[]|null
     */
    public function getOptionValues(): ?array
    {
        return $this->optionValues;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\ProductOptionValue[]|null $optionValues
     * @return \Bigcommerce\ORM\Entities\ProductOption
     */
    public function setOptionValues(?array $optionValues): ProductOption
    {
        $this->optionValues = $optionValues;

        return $this;
    }
}