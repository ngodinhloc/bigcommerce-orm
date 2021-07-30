<?php

declare(strict_types=1);

namespace Bigcommerce\ORM;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class AbstractEntity
 * @package Bigcommerce\ORM
 */
abstract class AbstractEntity
{
    /**
     * @var int|string|null
     * @BC\Field(name="id", readonly=true)
     */
    protected $id;

    /** @var bool */
    protected $isNew = false;

    /** @var bool */
    protected $isPatched = false;

    /** @var bool */
    protected $paymentAccessTokenRequired = false;

    /** @var \Bigcommerce\ORM\Entities\PaymentAccessToken */
    protected $paymentAccessToken = null;

    /** @var \Bigcommerce\ORM\Meta\Metadata */
    protected $metadata;

    /**
     * @return int|string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|string|null $id
     * @return \Bigcommerce\ORM\AbstractEntity
     */
    public function setId($id = null)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return $this->isNew;
    }

    /**
     * @return bool
     */
    public function isPaymentAccessTokenRequired()
    {
        return $this->paymentAccessTokenRequired;
    }

    /**
     * @return bool|null
     */
    public function isPatched()
    {
        return $this->isPatched;
    }

    /**
     * @return \Bigcommerce\ORM\Meta\Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return \Bigcommerce\ORM\Entities\PaymentAccessToken|null
     */
    public function getPaymentAccessToken()
    {
        return $this->paymentAccessToken;
    }
}
