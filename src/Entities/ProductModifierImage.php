<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class ProductModifierImage
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductModifierImage", path="/catalog/products/{product_id}/modifiers/{option_id}/image")
 */
class ProductModifierImage extends Entity
{
    /**
     * @var int
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var int
     * @BC\Field(name="option_id", readonly=true, pathParam=true)
     */
    protected $modifierId;

    /**
     * @var string
     * @BC\Field(name="image_file", upload=true)
     * @BC\File
     */
    protected $imageFile;

    /**
     * @var string
     * @BC\Field(name="image_url", readonly=true)
     * @BC\File
     */
    protected $imageUrl;

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductModifierImage
     */
    public function setProductId(int $productId = null): ProductModifierImage
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return int
     */
    public function getModifierId()
    {
        return $this->modifierId;
    }

    /**
     * @param int|null $modifierId
     * @return \Bigcommerce\ORM\Entities\ProductModifierImage
     */
    public function setModifierId(int $modifierId = null): ProductModifierImage
    {
        $this->modifierId = $modifierId;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string|null $imageFile
     * @return \Bigcommerce\ORM\Entities\ProductModifierImage
     */
    public function setImageFile(string $imageFile = null): ProductModifierImage
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string|null $imageUrl
     * @return \Bigcommerce\ORM\Entities\ProductModifierImage
     */
    public function setImageUrl(string $imageUrl = null): ProductModifierImage
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }
}