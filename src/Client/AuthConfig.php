<?php

declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

use Bigcommerce\ORM\Config\AuthCredential;
use Bigcommerce\ORM\Config\ConfigOption;

class AuthConfig extends AbstractConfig
{
    protected \Bigcommerce\ORM\Config\AuthCredential $credential;

    /**
     * AuthConfig constructor.
     * @param \Bigcommerce\ORM\Config\AuthCredential $credential
     * @param \Bigcommerce\ORM\Config\ConfigOption $configOption
     */
    public function __construct(AuthCredential $credential, ConfigOption $configOption)
    {
        $this->credential = $credential;
        $this->configOption = $configOption;
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->credential->getApiBaseUrl() . sprintf(
                $this->getApiStorePrefix(),
                $this->credential->getStoreHash()
            );
    }

    /**
     * @return string
     */
    public function getPaymentUrl()
    {
        return $this->credential->getPaymentBaseUrl() . sprintf(
                $this->getPaymentStorePrefix(),
                $this->credential->getStoreHash()
            );
    }

    /**
     * @return array|null
     */
    public function getAuth()
    {
        return null;
    }

    /**
     * @return array
     */
    public function getAuthHeaders()
    {
        return [
            'X-Auth-Client' => $this->credential->getClientId(),
            'X-Auth-Token' => $this->credential->getAuthToken()
        ];
    }

    /**
     * @return \Bigcommerce\ORM\Config\AuthCredential
     */
    public function getCredential(): AuthCredential
    {
        return $this->credential;
    }

    /**
     * @param \Bigcommerce\ORM\Config\AuthCredential $credential
     * @return \Bigcommerce\ORM\Client\AuthConfig
     */
    public function setCredential(AuthCredential $credential): AuthConfig
    {
        $this->credential = $credential;

        return $this;
    }
}
