<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class ProductComplexRule
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductComplexRule", path="/catalog/products/{product_id}/complex-rules", type="api")
 */
class ProductComplexRule extends AbstractEntity
{
    /**
     * @var int|null
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var int|null
     * @BC\Field(name="sort_order")
     */
    protected $sortOrder;

    /**
     * @var bool|null
     * @BC\Field(name="enabled")
     */
    protected $enabled;

    /**
     * @var bool|null
     * @BC\Field(name="stop")
     */
    protected $stop;

    /**
     * @var array|null
     * @BC\Field(name="price_adjuster")
     */
    protected $priceAdjuster;

    /**
     * @var array|null
     * @BC\Field(name="weight_adjuster")
     */
    protected $weightAdjuster;

    /**
     * @var bool|null
     * @BC\Field(name="purchasing_disabled")
     */
    protected $purchasingDisabled;

    /**
     * @var string|null
     * @BC\Field(name="purchasing_disabled_message")
     */
    protected $purchasingDisabledMessage;

    /**
     * @var bool|null
     * @BC\Field(name="purchasing_hidden")
     */
    protected $purchasingHidden;

    /**
     * @var string|null
     * @BC\Field(name="image_url")
     */
    protected $imageUrl;

    /**
     * @var array|null
     * @BC\Field(name="conditions")
     */
    protected $conditions;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setProductId(?int $productId): ProductComplexRule
    {
        $this->productId = $productId;

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
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setSortOrder(?int $sortOrder): ProductComplexRule
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    /**
     * @param bool|null $enabled
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setEnabled(?bool $enabled): ProductComplexRule
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isStop(): ?bool
    {
        return $this->stop;
    }

    /**
     * @param bool|null $stop
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setStop(?bool $stop): ProductComplexRule
    {
        $this->stop = $stop;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getPriceAdjuster(): ?array
    {
        return $this->priceAdjuster;
    }

    /**
     * @param array|null $priceAdjuster
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setPriceAdjuster(?array $priceAdjuster): ProductComplexRule
    {
        $this->priceAdjuster = $priceAdjuster;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getWeightAdjuster(): ?array
    {
        return $this->weightAdjuster;
    }

    /**
     * @param array|null $weightAdjuster
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setWeightAdjuster(?array $weightAdjuster): ProductComplexRule
    {
        $this->weightAdjuster = $weightAdjuster;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isPurchasingDisabled(): ?bool
    {
        return $this->purchasingDisabled;
    }

    /**
     * @param bool|null $purchasingDisabled
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setPurchasingDisabled(?bool $purchasingDisabled): ProductComplexRule
    {
        $this->purchasingDisabled = $purchasingDisabled;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPurchasingDisabledMessage(): ?string
    {
        return $this->purchasingDisabledMessage;
    }

    /**
     * @param string|null $purchasingDisabledMessage
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setPurchasingDisabledMessage(?string $purchasingDisabledMessage): ProductComplexRule
    {
        $this->purchasingDisabledMessage = $purchasingDisabledMessage;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isPurchasingHidden(): ?bool
    {
        return $this->purchasingHidden;
    }

    /**
     * @param bool|null $purchasingHidden
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setPurchasingHidden(?bool $purchasingHidden): ProductComplexRule
    {
        $this->purchasingHidden = $purchasingHidden;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @param string|null $imageUrl
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setImageUrl(?string $imageUrl): ProductComplexRule
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getConditions(): ?array
    {
        return $this->conditions;
    }

    /**
     * @param array|null $conditions
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setConditions(?array $conditions): ProductComplexRule
    {
        $this->conditions = $conditions;

        return $this;
    }
}