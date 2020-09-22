<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class CartCoupon
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CartCoupon", creatable=false, findable=false, deletable=false, updatable=false)
 */
class CartCoupon extends Entity
{
    /**
     * @var string|null
     * @BC\Field(name="code")
     */
    protected $code;

    /**
     * @var string|null
     * @BC\Field(name="name", readonly=true)
     */
    protected $name;

    /**
     * @var string|null
     * @BC\Field(name="coupon_type", readonly=true)
     */
    protected $type;

    /**
     * @var float|null
     * @BC\Field(name="discounted_amount", readonly=true)
     */
    protected $discountAmount;

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return \Bigcommerce\ORM\Entities\CartCoupon
     */
    public function setCode(?string $code): CartCoupon
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\CartCoupon
     */
    public function setName(?string $name): CartCoupon
    {
        $this->name = $name;

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
     * @return \Bigcommerce\ORM\Entities\CartCoupon
     */
    public function setType(?string $type): CartCoupon
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getDiscountAmount(): ?float
    {
        return $this->discountAmount;
    }

    /**
     * @param float|null $discountAmount
     * @return \Bigcommerce\ORM\Entities\CartCoupon
     */
    public function setDiscountAmount(?float $discountAmount): CartCoupon
    {
        $this->discountAmount = $discountAmount;

        return $this;
    }
}