<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class ProductComplexRule
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="ProductComplexRule", path="/catalog/products/{product_id}/complex-rules")
 */
class ProductComplexRule extends Entity
{
    /**
     * @var int
     * @BC\Field(name="product_id", readonly=true, pathParam=true)
     */
    protected $productId;

    /**
     * @var int
     * @BC\Field(name="sort_order")
     */
    protected $sortOrder;

    /**
     * @var bool
     * @BC\Field(name="enabled")
     */
    protected $enabled = false;

    /**
     * @var bool
     * @BC\Field(name="stop")
     */
    protected $stop = false;

    /**
     * @var array
     * @BC\Field(name="price_adjuster")
     */
    protected $priceAdjuster;

    /**
     * @var array
     * @BC\Field(name="weight_adjuster")
     */
    protected $weightAdjuster;

    /**
     * @var bool
     * @BC\Field(name="purchasing_disabled")
     */
    protected $purchasingDisabled = false;

    /**
     * @var string
     * @BC\Field(name="purchasing_disabled_message")
     */
    protected $purchasingDisabledMessage;

    /**
     * @var bool
     * @BC\Field(name="purchasing_hidden")
     */
    protected $purchasingHidden = false;

    /**
     * @var string
     * @BC\Field(name="image_url")
     */
    protected $imageUrl;

    /**
     * @var array
     * @BC\Field(name="conditions")
     */
    protected $conditions;

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setProductId(int $productId = null): ProductComplexRule
    {
        $this->productId = $productId;
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
     * @param int|null $sortOrder
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setSortOrder(int $sortOrder = null): ProductComplexRule
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setEnabled(bool $enabled = false): ProductComplexRule
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function isStop()
    {
        return $this->stop;
    }

    /**
     * @param bool $stop
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setStop(bool $stop = false): ProductComplexRule
    {
        $this->stop = $stop;
        return $this;
    }

    /**
     * @return array
     */
    public function getPriceAdjuster()
    {
        return $this->priceAdjuster;
    }

    /**
     * @param array|null $priceAdjuster
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setPriceAdjuster(array $priceAdjuster = null): ProductComplexRule
    {
        $this->priceAdjuster = $priceAdjuster;
        return $this;
    }

    /**
     * @return array
     */
    public function getWeightAdjuster()
    {
        return $this->weightAdjuster;
    }

    /**
     * @param array|null $weightAdjuster
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setWeightAdjuster(array $weightAdjuster = null): ProductComplexRule
    {
        $this->weightAdjuster = $weightAdjuster;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPurchasingDisabled()
    {
        return $this->purchasingDisabled;
    }

    /**
     * @param bool $purchasingDisabled
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setPurchasingDisabled(bool $purchasingDisabled = false): ProductComplexRule
    {
        $this->purchasingDisabled = $purchasingDisabled;
        return $this;
    }

    /**
     * @return string
     */
    public function getPurchasingDisabledMessage()
    {
        return $this->purchasingDisabledMessage;
    }

    /**
     * @param string|null $purchasingDisabledMessage
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setPurchasingDisabledMessage(string $purchasingDisabledMessage = null): ProductComplexRule
    {
        $this->purchasingDisabledMessage = $purchasingDisabledMessage;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPurchasingHidden()
    {
        return $this->purchasingHidden;
    }

    /**
     * @param bool $purchasingHidden
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setPurchasingHidden(bool $purchasingHidden = false): ProductComplexRule
    {
        $this->purchasingHidden = $purchasingHidden;
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
     * @param string|null $imageUrl
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setImageUrl(string $imageUrl = null): ProductComplexRule
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    /**
     * @return array
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param array|null $conditions
     * @return \Bigcommerce\ORM\Entities\ProductComplexRule
     */
    public function setConditions(array $conditions = null): ProductComplexRule
    {
        $this->conditions = $conditions;
        return $this;
    }
}