<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class CheckoutCoupon
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CheckoutCoupon", creatable=false, findable=false, deletable=false, updatable=false)
 */
class CheckoutCoupon extends AbstractEntity
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
     * @return \Bigcommerce\ORM\Entities\CheckoutCoupon
     */
    public function setCode(?string $code): CheckoutCoupon
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
     * @return \Bigcommerce\ORM\Entities\CheckoutCoupon
     */
    public function setName(?string $name): CheckoutCoupon
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
     * @return \Bigcommerce\ORM\Entities\CheckoutCoupon
     */
    public function setType(?string $type): CheckoutCoupon
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
     * @return \Bigcommerce\ORM\Entities\CheckoutCoupon
     */
    public function setDiscountAmount(?float $discountAmount): CheckoutCoupon
    {
        $this->discountAmount = $discountAmount;

        return $this;
    }
}