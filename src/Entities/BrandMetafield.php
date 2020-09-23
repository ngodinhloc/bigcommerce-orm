<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class BrandMetafield
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="BrandMetafield", path="/catalog/brands/{brand_id}/metafields", type="api")
 */
class BrandMetafield extends AbstractMetafield
{
    /**
     * @var int|null
     * @BC\Field(name="brand_id", readonly=true, pathParam=true)
     */
    protected $brandId;

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
}