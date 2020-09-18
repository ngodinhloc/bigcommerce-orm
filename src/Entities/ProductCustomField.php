<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class ProductCustomField
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductCustomField",path="/catalog/products/{product_id}/custom-fields")
 */
class ProductCustomField extends Entity
{
    /**
     * @var int
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var string
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var mixed
     * @BC\Field(name="value")
     */
    protected $value;

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductCustomField
     */
    public function setProductId(int $productId = null): ProductCustomField
    {
        $this->productId = $productId;
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
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\ProductCustomField
     */
    public function setName(string $name = null): ProductCustomField
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return \Bigcommerce\ORM\Entities\ProductCustomField
     */
    public function setValue($value = null)
    {
        $this->value = $value;
        return $this;
    }

}