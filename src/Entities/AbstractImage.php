<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class AbstractImage
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="AbstractImage")
 */
abstract class AbstractImage extends AbstractEntity
{
    /**
     * @var string|null
     * @BC\Field(name="image_file", upload=true)
     * @BC\File
     */
    protected $imageFile;

    /**
     * @var string|null
     * @BC\Field(name="image_url")
     */
    protected $imageUrl;

    /**
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @param string|null $imageUrl
     * @return \Bigcommerce\ORM\Entities\AbstractImage
     */
    public function setImageUrl(?string $imageUrl): AbstractImage
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageFile(): ?string
    {
        return $this->imageFile;
    }

    /**
     * @param string|null $imageFile
     * @return \Bigcommerce\ORM\Entities\AbstractImage
     */
    public function setImageFile(?string $imageFile): AbstractImage
    {
        $this->imageFile = $imageFile;

        return $this;
    }
}