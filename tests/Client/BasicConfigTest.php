<?php
declare(strict_types=1);

namespace Tests\Client;

use Bigcommerce\ORM\Client\BasicConfig;
use Bigcommerce\ORM\Client\Exceptions\ConfigException;
use Tests\BaseTestCase;

class BasicConfigTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Client\BasicConfig */
    protected $basicConfig;

    /**
     * @covers \Bigcommerce\ORM\Client\BasicConfig::__construct
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     */
    public function testConstruct()
    {
        $basicCredentials = [
            'username' => 'username',
            'apiKey' => 'apiKey'
        ];
        $this->expectException(ConfigException::class);
        $this->basicConfig = new BasicConfig($basicCredentials);
    }

    /**
     * @covers \Bigcommerce\ORM\Client\BasicConfig::__construct
     * @covers \Bigcommerce\ORM\Client\BasicConfig::setAccept
     * @covers \Bigcommerce\ORM\Client\BasicConfig::setApiKey
     * @covers \Bigcommerce\ORM\Client\BasicConfig::setUsername
     * @covers \Bigcommerce\ORM\Client\BasicConfig::setStoreUrl
     * @covers \Bigcommerce\ORM\Client\BasicConfig::setVerify
     * @covers \Bigcommerce\ORM\Client\BasicConfig::setApiVersion
     * @covers \Bigcommerce\ORM\Client\BasicConfig::setProxy
     * @covers \Bigcommerce\ORM\Client\BasicConfig::setDebug
     * @covers \Bigcommerce\ORM\Client\BasicConfig::setTimeout
     * @covers \Bigcommerce\ORM\Client\BasicConfig::getApiKey
     * @covers \Bigcommerce\ORM\Client\BasicConfig::getUsername
     * @covers \Bigcommerce\ORM\Client\BasicConfig::getStoreUrl
     * @covers \Bigcommerce\ORM\Client\BasicConfig::getAccept
     * @covers \Bigcommerce\ORM\Client\BasicConfig::getApiVersion
     * @covers \Bigcommerce\ORM\Client\BasicConfig::getProxy
     * @covers \Bigcommerce\ORM\Client\BasicConfig::getPathPrefix
     * @covers \Bigcommerce\ORM\Client\BasicConfig::getApiStorePrefix
     * @covers \Bigcommerce\ORM\Client\BasicConfig::getTimeout
     * @covers \Bigcommerce\ORM\Client\BasicConfig::getApiUrl
     * @covers \Bigcommerce\ORM\Client\BasicConfig::getPaymentUrl
     * @covers \Bigcommerce\ORM\Client\BasicConfig::getAuth
     * @covers \Bigcommerce\ORM\Client\BasicConfig::getAuthHeaders
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     */
    public function testSettersAndGetters()
    {
        $basicCredentials = [
            'storeUrl' => 'storeUrl',
            'username' => 'username',
            'apiKey' => 'apiKey'
        ];
        $this->basicConfig = new BasicConfig($basicCredentials);
        $this->assertEquals($basicCredentials['storeUrl'], $this->basicConfig->getStoreUrl());
        $this->assertEquals($basicCredentials['username'], $this->basicConfig->getUsername());
        $this->assertEquals($basicCredentials['apiKey'], $this->basicConfig->getApiKey());

        /** default values */
        $this->assertEquals('storeUrl/api/v3', $this->basicConfig->getApiUrl());
        $this->assertEquals('storeUrl/api/v3/payments', $this->basicConfig->getPaymentUrl());
        $this->assertEquals('/api/v3', $this->basicConfig->getPathPrefix());
        $this->assertEquals('/stores/%s/v3', $this->basicConfig->getApiStorePrefix());
        $this->assertEquals(null, $this->basicConfig->getProxy());
        $this->assertEquals(false, $this->basicConfig->isVerify());
        $this->assertEquals(60, $this->basicConfig->getTimeout());
        $this->assertEquals('application/json', $this->basicConfig->getAccept());
        $this->assertEquals('v3', $this->basicConfig->getApiVersion());
        $this->assertEquals(false, $this->basicConfig->isDebug());

        $this->basicConfig->setDebug(true)
            ->setProxy('proxy')
            ->setApiVersion('v3')
            ->setAccept('application/json')
            ->setVerify(true)
            ->setStoreUrl('url')
            ->setUsername('username')
            ->setApiKey('key');

        $this->assertEquals(true, $this->basicConfig->isDebug());
        $this->assertEquals('proxy', $this->basicConfig->getProxy());
        $this->assertEquals('v3', $this->basicConfig->getApiVersion());
        $this->assertEquals('application/json', $this->basicConfig->getAccept());
        $this->assertEquals(true, $this->basicConfig->isVerify());
        $this->assertEquals('url', $this->basicConfig->getStoreUrl());
        $this->assertEquals('username', $this->basicConfig->getUsername());
        $this->assertEquals('key', $this->basicConfig->getApiKey());

        $this->basicConfig->setAccept('invalidContentType');
        $this->assertEquals('application/json', $this->basicConfig->getAccept());
        $this->assertNull($this->basicConfig->getAuthHeaders());
        $this->assertEquals([$this->basicConfig->getUsername(), $this->basicConfig->getApiKey()], $this->basicConfig->getAuth());

    }
}