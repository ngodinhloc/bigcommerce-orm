<?php

declare(strict_types=1);

namespace Tests\Client;

use Bigcommerce\ORM\Client\AbstractConfig;
use Bigcommerce\ORM\Client\AuthConfig;
use Bigcommerce\ORM\Config\AuthCredential;
use Bigcommerce\ORM\Config\ConfigOption;
use Tests\BaseTestCase;

class AuthConfigTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Client\AuthConfig */
    protected $authConfig;

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ConfigException
     */
    public function testSettersAndGetters()
    {
        $authCredentials = [
            'clientId' => 'clientId',
            'authToken' => 'authToken',
            'storeHash' => 'storeHash',
            'apiUrl' => 'apiUrl',
            'paymentUrl' => 'paymentUrl'
        ];

        $credentials = new AuthCredential($authCredentials);
        $configOption = new ConfigOption();
        $this->authConfig = new AuthConfig($credentials, $configOption);
        $this->assertEquals($authCredentials['clientId'], $this->authConfig->getCredential()->getClientId());
        $this->assertEquals($authCredentials['authToken'], $this->authConfig->getCredential()->getAuthToken());
        $this->assertEquals($authCredentials['storeHash'], $this->authConfig->getCredential()->getStoreHash());
        $this->assertEquals($authCredentials['apiUrl'], $this->authConfig->getCredential()->getApiBaseUrl());
        $this->assertEquals($authCredentials['paymentUrl'], $this->authConfig->getCredential()->getPaymentBaseUrl());

        /** default values */
        $this->assertEquals('apiUrl/stores/storeHash/v3', $this->authConfig->getApiUrl());
        $this->assertEquals('paymentUrl/stores/storeHash', $this->authConfig->getPaymentUrl());
        $this->assertEquals('/api/v3', $this->authConfig->getPathPrefix());
        $this->assertEquals('/stores/%s/v3', $this->authConfig->getApiStorePrefix());
        $this->assertEquals(null, $this->authConfig->getConfigOption()->getProxy());
        $this->assertEquals(false, $this->authConfig->getConfigOption()->isVerify());
        $this->assertEquals(60, $this->authConfig->getConfigOption()->getTimeout());
        $this->assertEquals('application/json', $this->authConfig->getConfigOption()->getAccept());
        $this->assertEquals('v3', $this->authConfig->getConfigOption()->getApiVersion());
        $this->assertEquals(false, $this->authConfig->getConfigOption()->isDebug());

        $this->authConfig
            ->setConfigOption($configOption)
            ->setCredential($credentials);

        $this->assertEquals($configOption, $this->authConfig->getConfigOption());
        $this->assertEquals($credentials, $this->authConfig->getCredential());
        $this->assertEquals(60, $this->authConfig->getConfigOption()->getTimeout());
        $this->assertEquals(false, $this->authConfig->getConfigOption()->isDebug());
        $this->assertEquals(null, $this->authConfig->getConfigOption()->getProxy());
        $this->assertEquals('v3', $this->authConfig->getConfigOption()->getApiVersion());
        $this->assertEquals('application/json', $this->authConfig->getConfigOption()->getAccept());
        $this->assertEquals(false, $this->authConfig->getConfigOption()->isVerify());

        $this->assertEquals('clientId', $this->authConfig->getCredential()->getClientId());
        $this->assertEquals('authToken', $this->authConfig->getCredential()->getAuthToken());
        $this->assertEquals('storeHash', $this->authConfig->getCredential()->getStoreHash());
        $this->assertEquals('apiUrl', $this->authConfig->getCredential()->getApiBaseUrl());
        $this->assertEquals('paymentUrl', $this->authConfig->getCredential()->getPaymentBaseUrl());

        $this->assertEquals('application/json', $this->authConfig->getConfigOption()->getAccept());
        $this->assertEquals(ConfigOption::API_VERSION_V3, $this->authConfig->getConfigOption()->getApiVersion());
    }
}
