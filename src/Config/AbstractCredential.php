<?php

namespace Bigcommerce\ORM\Config;

class AbstractCredential
{
    const DEFAULT_API_BASE_URL = 'https://api.bigcommerce.com';
    const DEFAULT_PAYMENT_BASE_URL = 'https://payments.bigcommerce.com';
    protected string $apiBaseUrl = self::DEFAULT_API_BASE_URL;
    protected string $paymentBaseUrl = self::DEFAULT_PAYMENT_BASE_URL;

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
