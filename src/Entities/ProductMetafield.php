<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class ProductMetafield
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductMetafield",path="/catalog/products/{product_id}/metafields")
 */
class ProductMetafield extends Entity
{
    /**
     * @var int
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

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
     * @BC\Field(name="created_at")
     */
    protected $dateCreated;

    /**
     * @var string
     * @BC\Field(name="updated_at")
     */
    protected $dateModified;

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductMetafield
     */
    public function setProductId(int $productId = null): ProductMetafield
    {
        $this->productId = $productId;
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
     * @return \Bigcommerce\ORM\Entities\ProductMetafield
     */
    public function setKey(string $key = null): ProductMetafield
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
     * @return \Bigcommerce\ORM\Entities\ProductMetafield
     */
    public function setValue(string $value = null): ProductMetafield
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
     * @return \Bigcommerce\ORM\Entities\ProductMetafield
     */
    public function setNamespace(string $namespace = null): ProductMetafield
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
     * @return \Bigcommerce\ORM\Entities\ProductMetafield
     */
    public function setPermissionSet(string $permissionSet = null): ProductMetafield
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
     * @return \Bigcommerce\ORM\Entities\ProductMetafield
     */
    public function setResourceType(string $resourceType = null): ProductMetafield
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
     * @return \Bigcommerce\ORM\Entities\ProductMetafield
     */
    public function setResourceId(int $resourceId = null): ProductMetafield
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
     * @return \Bigcommerce\ORM\Entities\ProductMetafield
     */
    public function setDescription(string $description = null): ProductMetafield
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
     * @return \Bigcommerce\ORM\Entities\ProductMetafield
     */
    public function setDateCreated(string $dateCreated = null): ProductMetafield
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
     * @return \Bigcommerce\ORM\Entities\ProductMetafield
     */
    public function setDateModified(string $dateModified = null): ProductMetafield
    {
        $this->dateModified = $dateModified;
        return $this;
    }
}