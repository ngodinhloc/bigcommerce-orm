<?php

declare(strict_types=1);

namespace Tests\Config;

use Bigcommerce\ORM\Config\AuthCredential;
use Tests\BaseTestCase;

class AuthCredentialTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Config\AuthCredential */
    protected $credential;

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ConfigException
     */
    public function testSettersAndGetters()
    {
        $authCredentials = [
            'clientId' => '*clientId',
            'authToken' => 'authToken',
            'storeHash' => 'storeHash'
        ];

        $this->credential = new AuthCredential($authCredentials);
        $this->assertEquals($authCredentials['clientId'], $this->credential->getClientId());
        $this->assertEquals($authCredentials['authToken'], $this->credential->getAuthToken());
        $this->assertEquals($authCredentials['storeHash'], $this->credential->getStoreHash());
        $this->assertEquals(AuthCredential::API_BASE_URL, $this->credential->getApiBaseUrl());
        $this->assertEquals(AuthCredential::PAYMENT_BASE_URL, $this->credential->getPaymentBaseUrl());

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
