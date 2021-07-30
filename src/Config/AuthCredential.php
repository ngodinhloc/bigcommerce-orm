<?php

namespace Bigcommerce\ORM\Config;

use Bigcommerce\ORM\Exceptions\ConfigException;

class AuthCredential extends AbstractCredential
{
    const REQUIRED_CONFIGURATION_DATA = ['clientId', 'authToken', 'storeHash'];

    /** @var string */
    private $clientId;

    /** @var string */
    private $authToken;

    /** @var string */
    private $storeHash;

    /**
     * AuthCredential constructor.
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
        $this->clientId = $credentials['clientId'];
        $this->authToken = $credentials['authToken'];
        $this->storeHash = $credentials['storeHash'];
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
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     * @return \Bigcommerce\ORM\Config\AuthCredential
     */
    public function setClientId(string $clientId): AuthCredential
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
     * @param string $authToken
     * @return \Bigcommerce\ORM\Config\AuthCredential
     */
    public function setAuthToken(string $authToken): AuthCredential
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
     * @param string $storeHash
     * @return \Bigcommerce\ORM\Config\AuthCredential
     */
    public function setStoreHash(string $storeHash): AuthCredential
    {
        $this->storeHash = $storeHash;

        return $this;
    }
}
