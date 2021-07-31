<?php

declare(strict_types=1);

namespace Tests\Config;

use Bigcommerce\ORM\Config\AuthCredential;
use Bigcommerce\ORM\Exceptions\ConfigException;
use Tests\BaseTestCase;

class AuthCredentialTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Config\AuthCredential */
    protected $credential;

    public function testConstructionThrowException()
    {
        $authCredentials = [
            'clientId' => 'clientId',
            'authToken' => 'authToken'
        ];
        $this->expectException(ConfigException::class);
        $this->credential = new AuthCredential($authCredentials);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ConfigException
     */
    public function testWithPartialCredentials()
    {
        $authCredentials = [
            'clientId' => 'clientId',
            'authToken' => 'authToken',
            'storeHash' => 'storeHash',
        ];

        $this->credential = new AuthCredential($authCredentials);
        $this->assertEquals($authCredentials['clientId'], $this->credential->getClientId());
        $this->assertEquals($authCredentials['authToken'], $this->credential->getAuthToken());
        $this->assertEquals($authCredentials['storeHash'], $this->credential->getStoreHash());
        $this->assertEquals(AuthCredential::DEFAULT_API_BASE_URL, $this->credential->getApiBaseUrl());
        $this->assertEquals(AuthCredential::DEFAULT_PAYMENT_BASE_URL, $this->credential->getPaymentBaseUrl());
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ConfigException
     */
    public function testWithFullCredentials()
    {
        $authCredentials = [
            'clientId' => 'clientId',
            'authToken' => 'authToken',
            'storeHash' => 'storeHash',
            'apiUrl'    => 'apiUrl',
            'paymentUrl' => 'paymentUrl'
        ];

        $this->credential = new AuthCredential($authCredentials);
        $this->assertEquals($authCredentials['clientId'], $this->credential->getClientId());
        $this->assertEquals($authCredentials['authToken'], $this->credential->getAuthToken());
        $this->assertEquals($authCredentials['storeHash'], $this->credential->getStoreHash());
        $this->assertEquals($authCredentials['apiUrl'], $this->credential->getApiBaseUrl());
        $this->assertEquals($authCredentials['paymentUrl'], $this->credential->getPaymentBaseUrl());

        $this->credential
            ->setClientId('clientId')
            ->setAuthToken('authToken')
            ->setStoreHash('hash')
            ->setApiBaseUrl('url')
            ->setPaymentBaseUrl('payment');

        $this->assertEquals('clientId', $this->credential->getClientId());
        $this->assertEquals('authToken', $this->credential->getAuthToken());
        $this->assertEquals('hash', $this->credential->getStoreHash());
        $this->assertEquals('url', $this->credential->getApiBaseUrl());
        $this->assertEquals('payment', $this->credential->getPaymentBaseUrl());
    }
}
