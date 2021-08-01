<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ProductImage
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductImage", path="/catalog/products/{product_id}/images", type="api")
 */
class ProductImage extends AbstractImage
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var bool
     * @BC\Field(name="is_thumbnail")
     */
    protected $isThumbnail = false;

    /**
     * @var int|null
     * @BC\Field(name="sort_order")
     */
    protected $sortOrder;

    /**
     * @var string|null
     * @BC\Field(name="description")
     */
    protected $description;

    /**
     * @var string|null
     * @BC\Field(name="url_zoom")
     */
    protected $urlZoom;

    /**
     * @var string|null
     * @BC\Field(name="url_standard")
     */
    protected $urlStandard;

    /**
     * @var string|null
     * @BC\Field(name="url_thumbnail")
     */
    protected $urlThumbnail;

    /**
     * @var string|null
     * @BC\Field(name="url_tiny")
     */
    protected $urlTiny;

    /**
     * @var string|null
     * @BC\Field(name="date_modified")
     * @BC\Date
     */
    protected $dateModified;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setProductId(?int $productId): ProductImage
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * @return bool
     */
    public function isThumbnail(): ?bool
    {
        return $this->isThumbnail;
    }

    /**
     * @param bool $isThumbnail
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setIsThumbnail(bool $isThumbnail): ProductImage
    {
        $this->isThumbnail = $isThumbnail;

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
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setSortOrder(?int $sortOrder): ProductImage
    {
        $this->sortOrder = $sortOrder;

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
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setDescription(?string $description): ProductImage
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrlZoom(): ?string
    {
        return $this->urlZoom;
    }

    /**
     * @param string|null $urlZoom
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setUrlZoom(?string $urlZoom): ProductImage
    {
        $this->urlZoom = $urlZoom;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrlStandard(): ?string
    {
        return $this->urlStandard;
    }

    /**
     * @param string|null $urlStandard
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setUrlStandard(?string $urlStandard): ProductImage
    {
        $this->urlStandard = $urlStandard;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrlThumbnail(): ?string
    {
        return $this->urlThumbnail;
    }

    /**
     * @param string|null $urlThumbnail
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setUrlThumbnail(?string $urlThumbnail): ProductImage
    {
        $this->urlThumbnail = $urlThumbnail;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrlTiny(): ?string
    {
        return $this->urlTiny;
    }

    /**
     * @param string|null $urlTiny
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setUrlTiny(?string $urlTiny): ProductImage
    {
        $this->urlTiny = $urlTiny;

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
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setDateModified(?string $dateModified): ProductImage
    {
        $this->dateModified = $dateModified;

        return $this;
    }
}
