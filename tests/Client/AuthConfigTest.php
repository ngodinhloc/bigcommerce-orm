<?php
declare(strict_types=1);

namespace Tests\Client;

use Bigcommerce\ORM\Client\AuthConfig;
use Tests\BaseTestCase;

class AuthConfigTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Client\AuthConfig */
    protected $authConfig;

    /**
     * @covers \Bigcommerce\ORM\Client\AuthConfig::__construct
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setTimeout
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setDebug
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setProxy
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setApiVersion
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setVerify
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setContentType
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setBaseUrl
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setStoreHash
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setAuthToken
     * @covers \Bigcommerce\ORM\Client\AuthConfig::setClientId
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getTimeout
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getStorePrefix
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getPathPrefix
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getApiUrl
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getProxy
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getApiVersion
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getContentType
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getStoreHash
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getAuthToken
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getClientId
     * @covers \Bigcommerce\ORM\Client\AuthConfig::getBaseUrl
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     */
    public function testSettersAndGetters()
    {
        $authCredentials = [
            'clientId' => '*clientId',
            'authToken' => 'authToken',
            'storeHash' => 'storeHash',
            'baseUrl' => 'baseUrl'
        ];

        $this->authConfig = new AuthConfig($authCredentials);
        $this->assertEquals($authCredentials['clientId'], $this->authConfig->getClientId());
        $this->assertEquals($authCredentials['authToken'], $this->authConfig->getAuthToken());
        $this->assertEquals($authCredentials['storeHash'], $this->authConfig->getStoreHash());
        $this->assertEquals($authCredentials['baseUrl'], $this->authConfig->getBaseUrl());

        /** default values */
        $this->assertEquals('baseUrl/stores/storeHash/v3', $this->authConfig->getApiUrl());
        $this->assertEquals('/api/v3', $this->authConfig->getPathPrefix());
        $this->assertEquals('/stores/%s/v3', $this->authConfig->getStorePrefix());
        $this->assertEquals(null, $this->authConfig->getProxy());
        $this->assertEquals(false, $this->authConfig->isVerify());
        $this->assertEquals(60, $this->authConfig->getTimeout());
        $this->assertEquals('application/json', $this->authConfig->getContentType());
        $this->assertEquals('v3', $this->authConfig->getApiVersion());
        $this->assertEquals(false, $this->authConfig->isDebug());

        $this->authConfig->setDebug(true)
            ->setProxy('proxy')
            ->setApiVersion('v3')
            ->setContentType('application/x-www-form-urlencoded')
            ->setVerify(true)
            ->setClientId('clientId')
            ->setAuthToken('authToken')
            ->setStoreHash('hash')
            ->setBaseUrl('url');


        $this->assertEquals(true, $this->authConfig->isDebug());
        $this->assertEquals('proxy', $this->authConfig->getProxy());
        $this->assertEquals('v3', $this->authConfig->getApiVersion());
        $this->assertEquals('application/x-www-form-urlencoded', $this->authConfig->getContentType());
        $this->assertEquals(true, $this->authConfig->isVerify());
        $this->assertEquals('clientId', $this->authConfig->getClientId());
        $this->assertEquals('authToken', $this->authConfig->getAuthToken());
        $this->assertEquals('hash', $this->authConfig->getStoreHash());
        $this->assertEquals('url', $this->authConfig->getBaseUrl());

        $this->authConfig->setContentType('invalidContentType');
        $this->assertEquals('application/x-www-form-urlencoded', $this->authConfig->getContentType());
    }
}