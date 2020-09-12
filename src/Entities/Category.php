<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class Category
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Category", path="/catalog/categories")
 */
class Category extends Entity
{
    /**
     * @var string
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var int
     * @BC\Field(name="parent_id")
     */
    protected $parentId;

    /**
     * @var string
     * @BC\Field(name="description")
     */
    protected $description;

    /**
     * @var int
     * @BC\Field(name="sort_order")
     */
    protected $sortOrder;

    /**
     * @var string
     * @BC\Field(name="page_title")
     */
    protected $pageTitle;

    /**
     * @var \Bigcommerce\ORM\Entities\Category
     * @BC\BelongToOne(name="parent", targetClass="\Bigcommerce\ORM\Entities\Category", field="parent_id", targetField="id", auto=true)
     */
    protected $parent;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return \Bigcommerce\ORM\Entities\Category
     */
    public function setName(string $name): Category
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return \Bigcommerce\ORM\Entities\Category
     */
    public function setDescription(string $description): Category
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param int $sortOrder
     * @return \Bigcommerce\ORM\Entities\Category
     */
    public function setSortOrder(int $sortOrder): Category
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * @return string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * @param string $pageTitle
     * @return \Bigcommerce\ORM\Entities\Category
     */
    public function setPageTitle(string $pageTitle): Category
    {
        $this->pageTitle = $pageTitle;
        return $this;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     * @return \Bigcommerce\ORM\Entities\Category
     */
    public function setParentId(int $parentId): Category
    {
        $this->parentId = $parentId;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param \Bigcommerce\ORM\Entities\Category $parent
     * @return \Bigcommerce\ORM\Entities\Category
     */
    public function setParent(\Bigcommerce\ORM\Entities\Category $parent): Category
    {
        $this->parent = $parent;
        return $this;
    }

}