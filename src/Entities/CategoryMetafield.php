<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class CategoryMetafield
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CategoryMetafield", path="/catalog/categories/{category_id}/metafields", type="api")
 */
class CategoryMetafield extends Entity
{
    /**
     * @var int|null
     * @BC\Field(name="category_id", readonly=true, pathParam=true)
     */
    protected $categoryId;

    /**
     * @var string|null
     * @BC\Field(name="key")
     */
    protected $key;

    /**
     * @var string|null
     * @BC\Field(name="value")
     */
    protected $value;

    /**
     * @var string|null
     * @BC\Field(name="namespace")
     */
    protected $namespace;

    /**
     * @var string|null
     * @BC\Field(name="permission_set")
     */
    protected $permissionSet;

    /**
     * @var string|null
     * @BC\Field(name="resource_type")
     */
    protected $resourceType;

    /**
     * @var int|null
     * @BC\Field(name="resource_id")
     */
    protected $resourceId;

    /**
     * @var string|null
     * @BC\Field(name="description")
     */
    protected $description;

    /**
     * @var string|null
     * @BC\Field(name="date_created")
     */
    protected $dateCreated;

    /**
     * @var string|null
     * @BC\Field(name="date_modified")
     */
    protected $dateModified;

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

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param string|null $key
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setKey(?string $key): CategoryMetafield
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setValue(?string $value): CategoryMetafield
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    /**
     * @param string|null $namespace
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setNamespace(?string $namespace): CategoryMetafield
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPermissionSet(): ?string
    {
        return $this->permissionSet;
    }

    /**
     * @param string|null $permissionSet
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setPermissionSet(?string $permissionSet): CategoryMetafield
    {
        $this->permissionSet = $permissionSet;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResourceType(): ?string
    {
        return $this->resourceType;
    }

    /**
     * @param string|null $resourceType
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setResourceType(?string $resourceType): CategoryMetafield
    {
        $this->resourceType = $resourceType;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getResourceId(): ?int
    {
        return $this->resourceId;
    }

    /**
     * @param int|null $resourceId
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setResourceId(?int $resourceId): CategoryMetafield
    {
        $this->resourceId = $resourceId;
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
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setDescription(?string $description): CategoryMetafield
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateCreated(): ?string
    {
        return $this->dateCreated;
    }

    /**
     * @param string|null $dateCreated
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setDateCreated(?string $dateCreated): CategoryMetafield
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateModified(): ?string
    {
        return $this->dateModified;
    }

    /**
     * @param string|null $dateModified
     * @return \Bigcommerce\ORM\Entities\CategoryMetafield
     */
    public function setDateModified(?string $dateModified): CategoryMetafield
    {
        $this->dateModified = $dateModified;
        return $this;
    }
}