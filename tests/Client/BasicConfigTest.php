<?php

declare(strict_types=1);

namespace Tests\Client;

use Bigcommerce\ORM\Client\BasicConfig;
use Bigcommerce\ORM\Config\BasicCredential;
use Bigcommerce\ORM\Config\ConfigOption;
use Tests\BaseTestCase;

class BasicConfigTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Client\BasicConfig */
    protected $basicConfig;

    public function testSettersAndGetters()
    {
        $basicCredentials = [
            'storeUrl' => 'storeUrl',
            'username' => 'username',
            'apiKey' => 'apiKey'
        ];
        $credentials = new BasicCredential($basicCredentials);
        $configOption = new ConfigOption();
        $this->basicConfig = new BasicConfig($credentials, $configOption);
        $this->assertEquals($basicCredentials['storeUrl'], $this->basicConfig->getCredential()->getStoreUrl());
        $this->assertEquals($basicCredentials['username'], $this->basicConfig->getCredential()->getUsername());
        $this->assertEquals($basicCredentials['apiKey'], $this->basicConfig->getCredential()->getApiKey());

        /** default values */
        $this->assertEquals('storeUrl/api/v3', $this->basicConfig->getApiUrl());
        $this->assertEquals('storeUrl/api/v3/payments', $this->basicConfig->getPaymentUrl());
        $this->assertEquals('/api/v3', $this->basicConfig->getPathPrefix());
        $this->assertEquals('/stores/%s/v3', $this->basicConfig->getApiStorePrefix());
        $this->assertEquals(null, $this->basicConfig->getConfigOption()->getProxy());
        $this->assertEquals(false, $this->basicConfig->getConfigOption()->isVerify());
        $this->assertEquals(60, $this->basicConfig->getConfigOption()->getTimeout());
        $this->assertEquals('application/json', $this->basicConfig->getConfigOption()->getAccept());
        $this->assertEquals('v3', $this->basicConfig->getConfigOption()->getApiVersion());
        $this->assertEquals(false, $this->basicConfig->getConfigOption()->isDebug());

        $this->basicConfig
            ->setConfigOption($configOption)
            ->setCredential($credentials);

        $this->assertEquals($credentials, $this->basicConfig->getCredential());
        $this->assertEquals($configOption, $this->basicConfig->getConfigOption());
        $this->assertEquals(false, $this->basicConfig->getConfigOption()->isDebug());
        $this->assertEquals(null, $this->basicConfig->getConfigOption()->getProxy());
        $this->assertEquals('v3', $this->basicConfig->getConfigOption()->getApiVersion());
        $this->assertEquals('application/json', $this->basicConfig->getConfigOption()->getAccept());
        $this->assertEquals(false, $this->basicConfig->getConfigOption()->isVerify());
        $this->assertEquals('storeUrl', $this->basicConfig->getCredential()->getStoreUrl());
        $this->assertEquals('username', $this->basicConfig->getCredential()->getUsername());
        $this->assertEquals('apiKey', $this->basicConfig->getCredential()->getApiKey());

        $this->assertEquals('application/json', $this->basicConfig->getConfigOption()->getAccept());
        $this->assertNull($this->basicConfig->getAuthHeaders());
        $this->assertEquals(
            [$this->basicConfig->getCredential()->getUsername(), $this->basicConfig->getCredential()->getApiKey()],
            $this->basicConfig->getAuth()
        );
    }
}
