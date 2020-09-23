<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CategoryMetafield
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CategoryMetafield", path="/catalog/categories/{category_id}/metafields", type="api")
 */
class CategoryMetafield extends AbstractMetafield
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
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setCategoryId(?int $categoryId): CategoryMetafield
    {
        $this->categoryId = $categoryId;

        return $this;
    }
}