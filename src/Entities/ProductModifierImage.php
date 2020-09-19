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
     * @var string|null
     * @BC\Field(name="image_file", upload=true)
     * @BC\File
     */
    protected $imageFile;

    /**
     * @var string|null
     * @BC\Field(name="image_url", readonly=true)
     * @BC\File
     */
    protected $imageUrl;

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

    /**
     * @return string|null
     */
    public function getImageFile(): ?string
    {
        return $this->imageFile;
    }

    /**
     * @param string|null $imageFile
     * @return \Bigcommerce\ORM\Entities\ProductModifierImage
     */
    public function setImageFile(?string $imageFile): ProductModifierImage
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @param string|null $imageUrl
     * @return \Bigcommerce\ORM\Entities\ProductModifierImage
     */
    public function setImageUrl(?string $imageUrl): ProductModifierImage
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }
}