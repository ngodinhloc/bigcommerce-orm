<?php

declare(strict_types=1);

namespace Tests\Config;

use Bigcommerce\ORM\Config\BasicCredential;
use Bigcommerce\ORM\Exceptions\ConfigException;
use Tests\BaseTestCase;

class BasicCredentialTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Config\BasicCredential */
    protected $basicCredential;

    public function testConstructionThrowException()
    {
        $authCredentials = [
            'clientId' => 'clientId',
            'authToken' => 'authToken'
        ];
        $this->expectException(ConfigException::class);
        $this->basicCredential = new BasicCredential($authCredentials);
    }

    public function testWithPartialCredentials()
    {
        $basicCredentials = [
            'storeUrl' => 'storeUrl',
            'username' => 'username',
            'apiKey' => 'apiKey',

        ];
        $this->basicCredential = new BasicCredential($basicCredentials);
        $this->assertEquals($basicCredentials['storeUrl'], $this->basicCredential->getStoreUrl());
        $this->assertEquals($basicCredentials['username'], $this->basicCredential->getUsername());
        $this->assertEquals($basicCredentials['apiKey'], $this->basicCredential->getApiKey());
        $this->assertEquals(BasicCredential::DEFAULT_API_BASE_URL, $this->basicCredential->getApiBaseUrl());
        $this->assertEquals(BasicCredential::DEFAULT_PAYMENT_BASE_URL, $this->basicCredential->getPaymentBaseUrl());
    }

    public function testWithFullCredentials()
    {
        $basicCredentials = [
            'storeUrl' => 'storeUrl',
            'username' => 'username',
            'apiKey' => 'apiKey',
            'apiUrl'    => 'apiUrl',
            'paymentUrl' => 'paymentUrl'
        ];
        $this->basicCredential = new BasicCredential($basicCredentials);
        $this->assertEquals($basicCredentials['storeUrl'], $this->basicCredential->getStoreUrl());
        $this->assertEquals($basicCredentials['username'], $this->basicCredential->getUsername());
        $this->assertEquals($basicCredentials['apiKey'], $this->basicCredential->getApiKey());
        $this->assertEquals($basicCredentials['apiUrl'], $this->basicCredential->getApiBaseUrl());
        $this->assertEquals($basicCredentials['paymentUrl'], $this->basicCredential->getPaymentBaseUrl());

        $this->basicCredential
            ->setStoreUrl('url')
            ->setUsername('username')
            ->setApiKey('key')
            ->setApiBaseUrl('apiUrl')
            ->setPaymentBaseUrl('paymentUrl');

        $this->assertEquals('url', $this->basicCredential->getStoreUrl());
        $this->assertEquals('username', $this->basicCredential->getUsername());
        $this->assertEquals('key', $this->basicCredential->getApiKey());
        $this->assertEquals('apiUrl', $this->basicCredential->getApiBaseUrl());
        $this->assertEquals('paymentUrl', $this->basicCredential->getPaymentBaseUrl());
    }
}
