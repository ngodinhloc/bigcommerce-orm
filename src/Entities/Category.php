<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class Category
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Category", path="/catalog/categories", type="api")
 */
class Category extends Entity
{
    /**
     * @var string|null
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var string|null
     * @BC\Field(name="description")
     */
    protected $description;

    /**
     * @var int|null
     * @BC\Field(name="sort_order")
     */
    protected $sortOrder;

    /**
     * @var string|null
     * @BC\Field(name="page_title")
     */
    protected $pageTitle;

    /**
     * @var int|null
     * @BC\Field(name="parent_id")
     */
    protected $parentId;

    /**
     * @var \Bigcommerce\ORM\Entities\Category|null
     * @BC\BelongToOne(name="parent", targetClass="\Bigcommerce\ORM\Entities\Category", field="parent_id", targetField="id", from="api", auto=true)
     */
    protected $parent;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\Category
     */
    public function setName(?string $name): Category
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return \Bigcommerce\ORM\Entities\Category
     */
    public function setDescription(?string $description): Category
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    /**
     * @param int|null $sortOrder
     * @return \Bigcommerce\ORM\Entities\Category
     */
    public function setSortOrder(?int $sortOrder): Category
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPageTitle(): ?string
    {
        return $this->pageTitle;
    }

    /**
     * @param string|null $pageTitle
     * @return \Bigcommerce\ORM\Entities\Category
     */
    public function setPageTitle(?string $pageTitle): Category
    {
        $this->pageTitle = $pageTitle;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    /**
     * @param int|null $parentId
     * @return \Bigcommerce\ORM\Entities\Category
     */
    public function setParentId(?int $parentId): Category
    {
        $this->parentId = $parentId;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\Category|null
     */
    public function getParent(): ?\Bigcommerce\ORM\Entities\Category
    {
        return $this->parent;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\Category|null $parent
     * @return \Bigcommerce\ORM\Entities\Category
     */
    public function setParent(?\Bigcommerce\ORM\Entities\Category $parent): Category
    {
        $this->parent = $parent;
        return $this;
    }
}