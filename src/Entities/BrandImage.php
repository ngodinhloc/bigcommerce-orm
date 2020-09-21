<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class BrandImage
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="BrandImage", path="/catalog/brands/{brand_id}/image", type="api")
 */
class BrandImage extends Entity
{
    /**
     * @var int|null
     * @BC\Field(name="brand_id", readonly=true, pathParam=true)
     */
    protected $brandId;

    /**
     * @var string|null
     * @BC\Field(name="image_file", upload=true)
     * @BC\File
     */
    protected $imageFile;

    /**
     * @var string|null
     * @BC\Field(name="image_url")
     */
    protected $imageUrl;

    /**
     * @return int|null
     */
    public function getBrandId(): ?int
    {
        return $this->brandId;
    }

    /**
     * @param int|null $brandId
     * @return \Bigcommerce\ORM\Entities\BrandImage
     */
    public function setBrandId(?int $brandId): BrandImage
    {
        $this->brandId = $brandId;
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
     * @return \Bigcommerce\ORM\Entities\BrandImage
     */
    public function setImageUrl(?string $imageUrl): BrandImage
    {
        $this->imageUrl = $imageUrl;
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
     * @return \Bigcommerce\ORM\Entities\BrandImage
     */
    public function setImageFile(?string $imageFile): BrandImage
    {
        $this->imageFile = $imageFile;
        return $this;
    }
}