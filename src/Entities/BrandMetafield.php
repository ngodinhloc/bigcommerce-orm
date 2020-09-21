<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class BrandMetafield
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="BrandMetafield", path="/catalog/brands/{brand_id}/metafields", type="api")
 */
class BrandMetafield extends Entity
{
    /**
     * @var int|null
     * @BC\Field(name="brand_id", readonly=true, pathParam=true)
     */
    protected $brandId;

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
     * @BC\Field(name="created_at")
     */
    protected $dateCreated;

    /**
     * @var string|null
     * @BC\Field(name="updated_at")
     */
    protected $dateModified;

    /**
     * @return int|null
     */
    public function getBrandId(): ?int
    {
        return $this->brandId;
    }

    /**
     * @param int|null $brandId
     * @return \Bigcommerce\ORM\Entities\BrandMetafield
     */
    public function setBrandId(?int $brandId): BrandMetafield
    {
        $this->brandId = $brandId;
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
     * @return \Bigcommerce\ORM\Entities\BrandMetafield
     */
    public function setKey(?string $key): BrandMetafield
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
     * @return \Bigcommerce\ORM\Entities\BrandMetafield
     */
    public function setValue(?string $value): BrandMetafield
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
     * @return \Bigcommerce\ORM\Entities\BrandMetafield
     */
    public function setNamespace(?string $namespace): BrandMetafield
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
     * @return \Bigcommerce\ORM\Entities\BrandMetafield
     */
    public function setPermissionSet(?string $permissionSet): BrandMetafield
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
     * @return \Bigcommerce\ORM\Entities\BrandMetafield
     */
    public function setResourceType(?string $resourceType): BrandMetafield
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
     * @return \Bigcommerce\ORM\Entities\BrandMetafield
     */
    public function setResourceId(?int $resourceId): BrandMetafield
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
     * @return \Bigcommerce\ORM\Entities\BrandMetafield
     */
    public function setDescription(?string $description): BrandMetafield
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
     * @return \Bigcommerce\ORM\Entities\BrandMetafield
     */
    public function setDateCreated(?string $dateCreated): BrandMetafield
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
     * @return \Bigcommerce\ORM\Entities\BrandMetafield
     */
    public function setDateModified(?string $dateModified): BrandMetafield
    {
        $this->dateModified = $dateModified;
        return $this;
    }
}