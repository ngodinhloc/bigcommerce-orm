<?php
declare(strict_types=1);

namespace Tests\Client;

use Bigcommerce\ORM\Client\AbstractConfig;
use Bigcommerce\ORM\Client\AuthConfig;
use Bigcommerce\ORM\Client\Exceptions\ConfigException;
use Tests\BaseTestCase;

class AuthConfigTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Client\AuthConfig */
    protected $authConfig;

    /**
     * @covers \Bigcommerce\ORM\Client\AuthConfig::__construct
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     */
    public function testConstruct()
    {
        $authCredentials = [
            'authToken' => 'authToken',
            'storeHash' => 'storeHash',
            'apiUrl' => 'apiUrl',
            'paymentUrl' => 'paymentUrl'
        ];
        $this->expectException(ConfigException::class);
        $this->authConfig = new AuthConfig($authCredentials);
    }

    /**
     * @covers \Bigcommerce\ORM\Client\AuthConfig::__construct
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setTimeout
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setDebug
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setProxy
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setApiVersion
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setVerify
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setAccept
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setApiBaseUrl
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setPaymentBaseUrl
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setStoreHash
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setAuthToken
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setClientId
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getTimeout
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getApiStorePrefix
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getPathPrefix
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getApiBaseUrl
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getProxy
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getApiVersion
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getAccept
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getStoreHash
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getAuthToken
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getClientId
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getApiBaseUrl
     * @covers \Bigcommerce\ORM\Client\AuthConfig::isDebug
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getApiUrl
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getPaymentUrl
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getPaymentStorePrefix
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getAuth
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getAuthHeaders
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     */
    public function testSettersAndGetters()
    {
        $authCredentials = [
            'clientId' => '*clientId',
            'authToken' => 'authToken',
            'storeHash' => 'storeHash',
            'apiUrl' => 'apiUrl',
            'paymentUrl' => 'paymentUrl'
        ];

        $this->authConfig = new AuthConfig($authCredentials);
        $this->assertEquals($authCredentials['clientId'], $this->authConfig->getClientId());
        $this->assertEquals($authCredentials['authToken'], $this->authConfig->getAuthToken());
        $this->assertEquals($authCredentials['storeHash'], $this->authConfig->getStoreHash());
        $this->assertEquals($authCredentials['apiUrl'], $this->authConfig->getApiBaseUrl());
        $this->assertEquals($authCredentials['paymentUrl'], $this->authConfig->getPaymentBaseUrl());

        /** default values */
        $this->assertEquals('apiUrl/stores/storeHash/v3', $this->authConfig->getApiUrl());
        $this->assertEquals('paymentUrl/stores/storeHash', $this->authConfig->getPaymentUrl());
        $this->assertEquals('/api/v3', $this->authConfig->getPathPrefix());
        $this->assertEquals('/stores/%s/v3', $this->authConfig->getApiStorePrefix());
        $this->assertEquals(null, $this->authConfig->getProxy());
        $this->assertEquals(false, $this->authConfig->isVerify());
        $this->assertEquals(60, $this->authConfig->getTimeout());
        $this->assertEquals('application/json', $this->authConfig->getAccept());
        $this->assertEquals('v3', $this->authConfig->getApiVersion());
        $this->assertEquals(false, $this->authConfig->isDebug());

        $this->authConfig->setDebug(true)
            ->setTimeout(60)
            ->setProxy('proxy')
            ->setApiVersion('v3')
            ->setAccept('application/json')
            ->setVerify(true)
            ->setClientId('clientId')
            ->setAuthToken('authToken')
            ->setStoreHash('hash')
            ->setApiBaseUrl('url')
            ->setPaymentBaseUrl('payment');

        $this->assertEquals(60, $this->authConfig->getTimeout());
        $this->assertEquals(true, $this->authConfig->isDebug());
        $this->assertEquals('proxy', $this->authConfig->getProxy());
        $this->assertEquals('v3', $this->authConfig->getApiVersion());
        $this->assertEquals('application/json', $this->authConfig->getAccept());
        $this->assertEquals(true, $this->authConfig->isVerify());
        $this->assertEquals('clientId', $this->authConfig->getClientId());
        $this->assertEquals('authToken', $this->authConfig->getAuthToken());
        $this->assertEquals('hash', $this->authConfig->getStoreHash());
        $this->assertEquals('url', $this->authConfig->getApiBaseUrl());
        $this->assertEquals('payment', $this->authConfig->getPaymentBaseUrl());

        $this->authConfig->setAccept('invalidContentType');
        $this->assertEquals('application/json', $this->authConfig->getAccept());

        $this->authConfig->setApiVersion('v2');
        $this->assertEquals(AbstractConfig::API_VERSION_V3, $this->authConfig->getApiVersion());
    }
}
