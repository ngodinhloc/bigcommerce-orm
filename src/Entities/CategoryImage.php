<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class CategoryImage
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CategoryImage",path="/catalog/categories/{category_id}/image")
 */
class CategoryImage extends Entity
{
    /**
     * @var int
     * @BC\Field(name="category_id", readonly=true, pathParam=true)
     */
    protected $categoryId;

    /**
     * @var string
     * @BC\Field(name="image_file", upload=true)
     * @BC\File()
     */
    protected $imageFile;

    /**
     * @var string
     * @BC\Field(name="image_url", readonly=true)
     * @BC\Url()
     */
    protected $imageUrl;

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int|null $categoryId
     * @return CategoryImage
     */
    public function setCategoryId(int $categoryId = null): CategoryImage
    {
        $this->categoryId = $categoryId;
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
     * @return CategoryImage
     */
    public function setImageFile(string $imageFile = null): CategoryImage
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
     * @return CategoryImage
     */
    public function setImageUrl(string $imageUrl = null): CategoryImage
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }
}