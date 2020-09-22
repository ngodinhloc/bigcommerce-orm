<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

use Bigcommerce\ORM\Client\Exceptions\ConfigException;

class AuthConfig extends AbstractConfig
{
    /** @var string */
    protected $apiBaseUrl = self::API_BASE_URL;

    /** @var string */
    protected $paymentBaseUrl = self::PAYMENT_BASE_URL;

    /** @var string */
    protected $clientId;

    /** @var string */
    protected $authToken;

    /** @var string */
    protected $storeHash;

    const REQUIRED_CONFIGURATION_DATA = ['clientId', 'authToken', 'storeHash'];

    /**
     * AuthConfig constructor.
     *
     * @param array $config config
     * [
     *  'clientId' =>
     *  'authToken' =>
     *  'storeHash' =>
     *  'apiUrl' =>
     *  'paymentUrl' =>
     * ]
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     */
    public function __construct(array $config = null)
    {
        if (!isset($config['clientId']) || !isset($config['authToken']) || !isset($config['storeHash'])) {
            throw new ConfigException(ConfigException::ERROR_MISSING_CONFIG . implode(",", self::REQUIRED_CONFIGURATION_DATA));
        }
        $this->clientId = $config['clientId'];
        $this->authToken = $config['authToken'];
        $this->storeHash = $config['storeHash'];
        if (isset($config['apiUrl'])) {
            $this->apiBaseUrl = $config['apiUrl'];
        }
        if (isset($config['paymentUrl'])) {
            $this->paymentBaseUrl = $config['paymentUrl'];
        }
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @param string|null $clientId
     * @return \Bigcommerce\ORM\Client\AuthConfig
     */
    public function setClientId(string $clientId = null): AuthConfig
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    /**
     * @param string|null $authToken
     * @return \Bigcommerce\ORM\Client\AuthConfig
     */
    public function setAuthToken(string $authToken = null): AuthConfig
    {
        $this->authToken = $authToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getStoreHash(): string
    {
        return $this->storeHash;
    }

    /**
     * @param string|null $storeHash
     * @return \Bigcommerce\ORM\Client\AuthConfig
     */
    public function setStoreHash(string $storeHash = null): AuthConfig
    {
        $this->storeHash = $storeHash;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiBaseUrl(): string
    {
        return $this->apiBaseUrl;
    }

    /**
     * @param string $apiBaseUrl
     * @return \Bigcommerce\ORM\Client\AuthConfig
     */
    public function setApiBaseUrl(string $apiBaseUrl): AuthConfig
    {
        $this->apiBaseUrl = $apiBaseUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentBaseUrl(): string
    {
        return $this->paymentBaseUrl;
    }

    /**
     * @param string $paymentBaseUrl
     * @return \Bigcommerce\ORM\Client\AuthConfig
     */
    public function setPaymentBaseUrl(string $paymentBaseUrl): AuthConfig
    {
        $this->paymentBaseUrl = $paymentBaseUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->getApiBaseUrl() . sprintf($this->getApiStorePrefix(), $this->getStoreHash());
    }

    /**
     * @return string
     */
    public function getPaymentUrl()
    {
        return $this->getPaymentBaseUrl() . sprintf($this->getPaymentStorePrefix(), $this->getStoreHash());
    }
}
