<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ProductCustomField
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductCustomField", path="/catalog/products/{product_id}/custom-fields", type="api")
 */
class ProductCustomField extends AbstractEntity
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var string|null
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var mixed|null
     * @BC\Field(name="value")
     */
    protected $value;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductCustomField
     */
    public function setProductId(?int $productId): ProductCustomField
    {
        $this->productId = $productId;

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
     * @return \Bigcommerce\ORM\Entities\ProductCustomField
     */
    public function setName(?string $name): ProductCustomField
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed|null $value
     * @return \Bigcommerce\ORM\Entities\ProductCustomField
     */
    public function setValue($value): ProductCustomField
    {
        $this->value = $value;

        return $this;
    }
}