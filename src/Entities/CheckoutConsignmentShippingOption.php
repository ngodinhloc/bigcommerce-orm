<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CheckoutConsignmentShippingOption
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CheckoutConsignmentShippingOption", findable=false, creatable=false, updatable=false, deletable=false)
 */
class CheckoutConsignmentShippingOption extends AbstractEntity
{
    /**
     * @var string|null
     * @BC\Field(name="type", readonly=true)
     */
    protected $type;

    /**
     * @var string|null
     * @BC\Field(name="description", readonly=true)
     */
    protected $description;

    /**
     * @var string|null
     * @BC\Field(name="image_url", readonly=true)
     */
    protected $imageUrl;

    /**
     * @var float|null
     * @BC\Field(name="cost", readonly=true)
     */
    protected $cost;

    /**
     * @var string|null
     * @BC\Field(name="transit_time", readonly=true)
     */
    protected $transitTime;

    /**
     * @var string|null
     * @BC\Field(name="additional_description", readonly=true)
     */
    protected $additionalDescription;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption
     */
    public function setType(?string $type): CheckoutConsignmentShippingOption
    {
        $this->type = $type;

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
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption
     */
    public function setDescription(?string $description): CheckoutConsignmentShippingOption
    {
        $this->description = $description;

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
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption
     */
    public function setImageUrl(?string $imageUrl): CheckoutConsignmentShippingOption
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getCost(): ?float
    {
        return $this->cost;
    }

    /**
     * @param float|null $cost
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption
     */
    public function setCost(?float $cost): CheckoutConsignmentShippingOption
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTransitTime(): ?string
    {
        return $this->transitTime;
    }

    /**
     * @param string|null $transitTime
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption
     */
    public function setTransitTime(?string $transitTime): CheckoutConsignmentShippingOption
    {
        $this->transitTime = $transitTime;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdditionalDescription(): ?string
    {
        return $this->additionalDescription;
    }

    /**
     * @param string|null $additionalDescription
     * @return \Bigcommerce\ORM\Entities\CheckoutConsignmentShippingOption
     */
    public function setAdditionalDescription(?string $additionalDescription): CheckoutConsignmentShippingOption
    {
        $this->additionalDescription = $additionalDescription;

        return $this;
    }
}