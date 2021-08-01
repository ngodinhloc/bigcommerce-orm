<?php

namespace Tests\Client;

use Bigcommerce\ORM\Client\AuthConfig;
use Bigcommerce\ORM\Client\RequestOption;
use Bigcommerce\ORM\Config\AuthCredential;
use Bigcommerce\ORM\Config\ConfigOption;
use PHPUnit\Framework\TestCase;

class RequestOptionTest extends TestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Client\RequestOption */
    private $option;

    /** @var \Bigcommerce\ORM\Client\AbstractConfig */
    private $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = $this->getAuthConfig();
        $this->option = new RequestOption($this->config);
    }

    public function testSettersAndGetters(){
        $this->option
        ->setConfig($this->config)
        ->setOptions([])
        ->setHeaders([]);

        $this->assertSame([], $this->option->getHeaders());
        $this->assertSame([], $this->option->getOptions());
        $this->assertSame($this->config, $this->option->getConfig());
    }

    public function testAddEmptyRequestFile()
    {
        $this->option->addRequestFile([]);
        $this->assertArrayNotHasKey('multipart', $this->option->getOptions());
    }

    /**
     * @return \Bigcommerce\ORM\Client\AuthConfig
     * @throws \Bigcommerce\ORM\Exceptions\ConfigException
     */
    private function getAuthConfig()
    {
        $authCredentials = [
            'clientId' => 'clientId',
            'authToken' => 'authToken',
            'storeHash' => 'storeHash',
            'baseUrl' => 'baseUrl',
        ];
        $credential = new AuthCredential($authCredentials);
        $configOption = new ConfigOption();
        $configOption
            ->setTimeout(60)
            ->setAccept('application/json')
            ->setVerify(true)
            ->setDebug(true)
            ->setProxy('tcp://localhost:8080');

        return new AuthConfig($credential, $configOption);
    }
}
