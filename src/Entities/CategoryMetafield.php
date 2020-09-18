<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class CategoryMetafield
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CategoryMetafield", path="/catalog/categories/{category_id}/metafields")
 */
class CategoryMetafield extends Entity
{
    /**
     * @var int
     * @BC\Field(name="category_id", readonly=true, pathParam=true)
     */
    protected $categoryId;

    /**
     * @var string
     * @BC\Field(name="key")
     */
    protected $key;

    /**
     * @var string
     * @BC\Field(name="value")
     */
    protected $value;

    /**
     * @var string
     * @BC\Field(name="namespace")
     */
    protected $namespace;

    /**
     * @var string
     * @BC\Field(name="permission_set")
     */
    protected $permissionSet;

    /**
     * @var string
     * @BC\Field(name="resource_type")
     */
    protected $resourceType;

    /**
     * @var int
     * @BC\Field(name="resource_id")
     */
    protected $resourceId;

    /**
     * @var string
     * @BC\Field(name="description")
     */
    protected $description;

    /**
     * @var string
     * @BC\Field(name="date_created")
     */
    protected $dateCreated;

    /**
     * @var string
     * @BC\Field(name="date_modified")
     */
    protected $dateModified;

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int|null $categoryId
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setCategoryId(int $categoryId = null): CategoryMetafield
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string|null $key
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setKey(string $key = null): CategoryMetafield
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return CategoryMetafield
     */
    public function setValue(string $value = null): CategoryMetafield
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string|null $namespace
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setNamespace(string $namespace = null): CategoryMetafield
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * @return string
     */
    public function getPermissionSet()
    {
        return $this->permissionSet;
    }

    /**
     * @param string|null $permissionSet
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setPermissionSet(string $permissionSet = null): CategoryMetafield
    {
        $this->permissionSet = $permissionSet;
        return $this;
    }

    /**
     * @return string
     */
    public function getResourceType()
    {
        return $this->resourceType;
    }

    /**
     * @param string|null $resourceType
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setResourceType(string $resourceType = null): CategoryMetafield
    {
        $this->resourceType = $resourceType;
        return $this;
    }

    /**
     * @return int
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }

    /**
     * @param int|null $resourceId
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setResourceId(int $resourceId = null): CategoryMetafield
    {
        $this->resourceId = $resourceId;
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
     * @param string|null $description
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setDescription(string $description = null): CategoryMetafield
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param string|null $dateCreated
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setDateCreated(string $dateCreated = null): CategoryMetafield
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * @param string|null $dateModified
     * @return CategoryMetafield
     */
    public function setDateModified(string $dateModified = null): CategoryMetafield
    {
        $this->dateModified = $dateModified;
        return $this;
    }
}