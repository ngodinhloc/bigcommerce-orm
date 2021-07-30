<?php

namespace Bigcommerce\ORM\Config;

class AbstractCredential
{
    const API_BASE_URL = 'https://api.bigcommerce.com';
    const API_VERSION_V3 = "v3";
    const API_STORE_PREFIX_V3 = '/stores/%s/v3';
    const API_PATH_PREFIX_V3 = '/api/v3';
    const PAYMENT_BASE_URL = 'https://payments.bigcommerce.com';
    const PAYMENT_STORE_PREFIX = '/stores/%s';
    const RESOURCE_TYPE_API = 'api';
    const RESOURCE_TYPE_PAYMENT = 'payment';

    /** @var string */
    protected $apiBaseUrl = self::API_BASE_URL;

    /** @var string */
    protected $paymentBaseUrl = self::PAYMENT_BASE_URL;

    /**
     * @return string|null
     */
    public function getApiBaseUrl(): ?string
    {
        return $this->apiBaseUrl;
    }

    /**
     * @param string|null $apiBaseUrl
     * @return \Bigcommerce\ORM\Config\AbstractCredential
     */
    public function setApiBaseUrl(?string $apiBaseUrl): AbstractCredential
    {
        $this->apiBaseUrl = $apiBaseUrl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentBaseUrl(): ?string
    {
        return $this->paymentBaseUrl;
    }

    /**
     * @param string|null $paymentBaseUrl
     * @return \Bigcommerce\ORM\Config\AbstractCredential
     */
    public function setPaymentBaseUrl(?string $paymentBaseUrl): AbstractCredential
    {
        $this->paymentBaseUrl = $paymentBaseUrl;

        return $this;
    }
}
