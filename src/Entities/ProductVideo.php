<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class ProductVideo
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductVideo", path="/catalog/products/{product_id}/videos")
 */
class ProductVideo extends Entity
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", pathParam=true)
     */
    protected $productId;

    /**
     * @var string|null
     * @BC\Field(name="type")
     */
    protected $type;

    /**
     * @var string|null
     * @BC\Field(name="video_id")
     */
    protected $videoId;

    /**
     * @var int|null
     * @BC\Field(name="sort_order")
     */
    protected $sortOrder;

    /**
     * @var string|null
     * @BC\Field(name="title")
     */
    protected $title;

    /**
     * @var string|null
     * @BC\Field(name="description")
     */
    protected $description;

    /**
     * @var string|null
     * @BC\Field(name="length")
     */
    protected $length;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductVideo
     */
    public function setProductId(?int $productId): ProductVideo
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return \Bigcommerce\ORM\Entities\ProductVideo
     */
    public function setType(?string $type): ProductVideo
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    /**
     * @param string|null $videoId
     * @return \Bigcommerce\ORM\Entities\ProductVideo
     */
    public function setVideoId(?string $videoId): ProductVideo
    {
        $this->videoId = $videoId;
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
     * @return \Bigcommerce\ORM\Entities\ProductVideo
     */
    public function setSortOrder(?int $sortOrder): ProductVideo
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return \Bigcommerce\ORM\Entities\ProductVideo
     */
    public function setTitle(?string $title): ProductVideo
    {
        $this->title = $title;
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
     * @return \Bigcommerce\ORM\Entities\ProductVideo
     */
    public function setDescription(?string $description): ProductVideo
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLength(): ?string
    {
        return $this->length;
    }

    /**
     * @param string|null $length
     * @return \Bigcommerce\ORM\Entities\ProductVideo
     */
    public function setLength(?string $length): ProductVideo
    {
        $this->length = $length;
        return $this;
    }
}