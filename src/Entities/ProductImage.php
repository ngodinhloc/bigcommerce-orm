<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class ProductImage
 * @package Bigcommerce\ORM\Entities
 * @BC\BigObject(name="ProductImage", path="/catalog/products/{id}/images", parentField="product_id")
 */
class ProductImage extends Entity
{
    /**
     * @var int
     * @BC\Field(name="product_id", readonly=true)
     */
    protected $productId;

    /**
     * @var bool
     * @BC\Field(name="is_thumbnail")
     */
    protected $isThumbnail = false;

    /**
     * @var int
     * @BC\Field(name="sort_order")
     */

    protected $sortOrder;
    /**
     * @var string
     * @BC\Field(name="description")
     */
    protected $description;

    /**
     * @var string
     * @BC\Field(name="image_file", upload=true)
     */
    protected $imageFile;

    /**
     * @var string
     * @BC\Field(name="image_url")
     */
    protected $imageUrl;

    /**
     * @var string
     * @BC\Field(name="url_zoom")
     */
    protected $urlZoom;

    /**
     * @var string
     * @BC\Field(name="url_standard")
     */
    protected $urlStandard;

    /**
     * @var string
     * @BC\Field(name="url_thumbnail")
     */
    protected $urlThumbnail;

    /**
     * @var string
     * @BC\Field(name="url_tiny")
     */
    protected $urlTiny;

    /**
     * @var string
     * @BC\Field(name="date_modified")
     * @BC\Date
     */
    protected $dateModified;

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setProductId(int $productId): ProductImage
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return bool
     */
    public function isThumbnail()
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
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param int $sortOrder
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setSortOrder(int $sortOrder): ProductImage
    {
        $this->sortOrder = $sortOrder;
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
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setDescription(string $description): ProductImage
    {
        $this->description = $description;
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
     * @param string $imageFile
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setImageFile(string $imageFile): ProductImage
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
     * @param string $imageUrl
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setImageUrl(string $imageUrl): ProductImage
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlZoom()
    {
        return $this->urlZoom;
    }

    /**
     * @param string $urlZoom
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setUrlZoom(string $urlZoom): ProductImage
    {
        $this->urlZoom = $urlZoom;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlStandard()
    {
        return $this->urlStandard;
    }

    /**
     * @param string $urlStandard
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setUrlStandard(string $urlStandard): ProductImage
    {
        $this->urlStandard = $urlStandard;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlThumbnail()
    {
        return $this->urlThumbnail;
    }

    /**
     * @param string $urlThumbnail
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setUrlThumbnail(string $urlThumbnail): ProductImage
    {
        $this->urlThumbnail = $urlThumbnail;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlTiny()
    {
        return $this->urlTiny;
    }

    /**
     * @param string $urlTiny
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setUrlTiny(string $urlTiny): ProductImage
    {
        $this->urlTiny = $urlTiny;
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
     * @param string $dateModified
     * @return \Bigcommerce\ORM\Entities\ProductImage
     */
    public function setDateModified(string $dateModified): ProductImage
    {
        $this->dateModified = $dateModified;
        return $this;
    }
}