<?php

namespace Bigcommerce\ORM\Config;

use Bigcommerce\ORM\Exceptions\ConfigException;

class BasicCredential extends AbstractCredential
{
    const REQUIRED_CONFIGURATION_DATA = ['storeUrl', 'username', 'apiKey'];
    private string $storeUrl;
    private string $username;
    private string $apiKey;


    /**
     * BasicCredential constructor.
     * @param array $credentials
     * @throws \Bigcommerce\ORM\Exceptions\ConfigException
     */
    public function __construct(array $credentials)
    {
        if (!empty(array_diff(self::REQUIRED_CONFIGURATION_DATA, array_keys($credentials)))) {
            throw new ConfigException(
                ConfigException::ERROR_MISSING_CONFIG . implode(",", self::REQUIRED_CONFIGURATION_DATA)
            );
        }
        $this->storeUrl = $credentials['storeUrl'];
        $this->username = $credentials['username'];
        $this->apiKey = $credentials['apiKey'];
        if (isset($credentials['apiUrl'])) {
            $this->apiBaseUrl = $credentials['apiUrl'];
        }
        if (isset($credentials['paymentUrl'])) {
            $this->paymentBaseUrl = $credentials['paymentUrl'];
        }
    }

    /**
     * @return string
     */
    public function getStoreUrl(): string
    {
        return $this->storeUrl;
    }

    /**
     * @param string $storeUrl
     * @return \Bigcommerce\ORM\Config\BasicCredential
     */
    public function setStoreUrl(string $storeUrl): BasicCredential
    {
        $this->storeUrl = $storeUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return \Bigcommerce\ORM\Config\BasicCredential
     */
    public function setUsername(string $username): BasicCredential
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     * @return \Bigcommerce\ORM\Config\BasicCredential
     */
    public function setApiKey(string $apiKey): BasicCredential
    {
        $this->apiKey = $apiKey;

        return $this;
    }
}
