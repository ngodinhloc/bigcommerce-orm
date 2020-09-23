<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class AbstractVideo
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="AbstractVideo")
 */
class AbstractVideo extends AbstractEntity
{
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
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return \Bigcommerce\ORM\Entities\AbstractVideo
     */
    public function setType(?string $type): AbstractVideo
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
     * @return \Bigcommerce\ORM\Entities\AbstractVideo
     */
    public function setVideoId(?string $videoId): AbstractVideo
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
     * @return \Bigcommerce\ORM\Entities\AbstractVideo
     */
    public function setSortOrder(?int $sortOrder): AbstractVideo
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
     * @return \Bigcommerce\ORM\Entities\AbstractVideo
     */
    public function setTitle(?string $title): AbstractVideo
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
     * @return \Bigcommerce\ORM\Entities\AbstractVideo
     */
    public function setDescription(?string $description): AbstractVideo
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
     * @return \Bigcommerce\ORM\Entities\AbstractVideo
     */
    public function setLength(?string $length): AbstractVideo
    {
        $this->length = $length;

        return $this;
    }
}