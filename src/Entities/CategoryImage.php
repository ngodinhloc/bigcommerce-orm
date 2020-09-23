<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CategoryImage
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CategoryImage", path="/catalog/categories/{category_id}/image", type="api")
 */
class CategoryImage extends AbstractImage
{
    /**
     * @var int|null
     * @BC\Field(name="category_id", readonly=true, pathParam=true)
     */
    protected $categoryId;

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
}