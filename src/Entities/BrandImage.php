<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class BrandImage
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="BrandImage", path="/catalog/brands/{brand_id}/image", type="api")
 */
class BrandImage extends AbstractImage
{
    /**
     * @var int|null
     * @BC\Field(name="brand_id", readonly=true, pathParam=true)
     */
    protected $brandId;

    /**
     * @return int|null
     */
    public function getBrandId(): ?int
    {
        return $this->brandId;
    }

    /**
     * @param int|null $brandId
     * @return \Bigcommerce\ORM\Entities\BrandImage
     */
    public function setBrandId(?int $brandId): BrandImage
    {
        $this->brandId = $brandId;

        return $this;
    }
}