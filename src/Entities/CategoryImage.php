<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class CategoryImage
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CategoryImage", path="/catalog/categories/{category_id}/image")
 */
class CategoryImage extends Entity
{
    /**
     * @var int|null
     * @BC\Field(name="category_id", readonly=true, pathParam=true)
     */
    protected $categoryId;

    /**
     * @var string|null
     * @BC\Field(name="image_file", upload=true)
     * @BC\File()
     */
    protected $imageFile;

    /**
     * @var string|null
     * @BC\Field(name="image_url", readonly=true)
     * @BC\Url()
     */
    protected $imageUrl;

    /**
     * @return int|null
     */
    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    /**
     * @param int|null $categoryId
     * @return \Bigcommerce\ORM\Entities\CategoryImage
     */
    public function setCategoryId(?int $categoryId): CategoryImage
    {
        $this->categoryId = $categoryId;
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
     * @return \Bigcommerce\ORM\Entities\CategoryImage
     */
    public function setImageFile(?string $imageFile): CategoryImage
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
     * @return \Bigcommerce\ORM\Entities\CategoryImage
     */
    public function setImageUrl(?string $imageUrl): CategoryImage
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }
}