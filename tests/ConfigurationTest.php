<?php
declare(strict_types=1);

namespace Tests;

use Bigcommerce\ORM\Cache\FileCache\FileCachePool;
use Bigcommerce\ORM\Client\AuthConfig;
use Bigcommerce\ORM\Client\BasicConfig;
use Bigcommerce\ORM\Client\Client;
use Bigcommerce\ORM\Client\Exceptions\ConfigException;
use Bigcommerce\ORM\Configuration;
use Bigcommerce\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ConfigurationTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Cache\FileCache\FileCachePool|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $cache;

    /** @var \Symfony\Component\EventDispatcher\EventDispatcher|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $dispatcher;

    /** @var \Monolog\Logger|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $logger;

    /** @var array */
    protected $credentials;

    /** @var array */
    protected $options;

    /** @var \Bigcommerce\ORM\Configuration */
    protected $configuration;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cache = $this->prophet->prophesize(FileCachePool::class)->reveal();
        $this->dispatcher = $this->prophet->prophesize(EventDispatcher::class)->reveal();
        $this->logger = $this->prophet->prophesize(Logger::class)->reveal();
        $this->options = $this->getOptions();
    }

    /**
     * @covers \Bigcommerce\ORM\Configuration::setCredentials
     * @covers \Bigcommerce\ORM\Configuration::setOptions
     * @covers \Bigcommerce\ORM\Configuration::setEventDispatcher
     * @covers \Bigcommerce\ORM\Configuration::setCachePool
     * @covers \Bigcommerce\ORM\Configuration::setLogger
     * @covers \Bigcommerce\ORM\Configuration::getCredentials
     * @covers \Bigcommerce\ORM\Configuration::getOptions
     * @covers \Bigcommerce\ORM\Configuration::getEventDispatcher
     * @covers \Bigcommerce\ORM\Configuration::getCachePool
     * @covers \Bigcommerce\ORM\Configuration::getLogger
     */
    public function testSettersAndGetters()
    {
        $this->credentials = $this->getBasicCredential();
        $this->configuration = new Configuration();

        $this->configuration
            ->setCredentials($this->credentials)
            ->setOptions($this->options)
            ->setEventDispatcher($this->dispatcher)
            ->setCachePool($this->cache)
            ->setLogger($this->logger);
        $this->assertEquals($this->credentials, $this->configuration->getCredentials());
        $this->assertEquals($this->options, $this->configuration->getOptions());
        $this->assertEquals($this->dispatcher, $this->configuration->getEventDispatcher());
        $this->assertEquals($this->cache, $this->configuration->getCachePool());
        $this->assertEquals($this->logger, $this->configuration->getLogger());
    }

    /**
     * @covers \Bigcommerce\ORM\Configuration::__construct
     * @covers \Bigcommerce\ORM\Configuration::configEntityManager
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testInvalidCredentials()
    {
        $this->configuration = new Configuration([]);
        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage(ConfigException::ERROR_MISSING_CONFIG);
        $this->configuration->configEntityManager();
    }

    /**
     * @covers \Bigcommerce\ORM\Configuration::__construct
     * @covers \Bigcommerce\ORM\Configuration::configEntityManager
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testBasicCredential()
    {
        $this->credentials = $this->getBasicCredential();
        $this->configuration = new Configuration(
            $this->credentials,
            $this->options,
            $this->cache,
            $this->dispatcher,
            $this->logger
        );

        $entityManager = $this->configuration->configEntityManager();
        $this->assertInstanceOf(EntityManager::class, $entityManager);

        /** @var Client $client */
        $client = $entityManager->getClient();
        $this->assertEquals($this->dispatcher, $entityManager->getEventDispatcher());
        $this->assertEquals($this->cache, $client->getCachePool());

        $connection = $client->getConnection();
        /** @var BasicConfig $config */
        $config = $connection->getConfig();
        $this->assertInstanceOf(BasicConfig::class, $config);
        $this->assertEquals($this->credentials['storeUrl'], $config->getStoreUrl());
        $this->assertEquals($this->credentials['username'], $config->getUsername());
        $this->assertEquals($this->credentials['apiKey'], $config->getApiKey());
        $this->assertEquals($this->logger, $connection->getLogger());
    }

    /**
     * @covers \Bigcommerce\ORM\Configuration::__construct
     * @covers \Bigcommerce\ORM\Configuration::configEntityManager
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testAuthCredential()
    {
        $this->credentials = $this->getAuthCredential();
        $this->configuration = new Configuration(
            $this->credentials,
            $this->options,
            $this->cache,
            $this->dispatcher,
            $this->logger
        );

        $entityManager = $this->configuration->configEntityManager();
        $this->assertInstanceOf(EntityManager::class, $entityManager);

        /** @var Client $client */
        $client = $entityManager->getClient();
        $this->assertEquals($this->dispatcher, $entityManager->getEventDispatcher());
        $this->assertEquals($this->cache, $client->getCachePool());

        $connection = $client->getConnection();
        /** @var AuthConfig $config */
        $config = $connection->getConfig();
        $this->assertInstanceOf(AuthConfig::class, $config);
        $this->assertEquals($this->credentials['clientId'], $config->getClientId());
        $this->assertEquals($this->credentials['authToken'], $config->getAuthToken());
        $this->assertEquals($this->credentials['storeHash'], $config->getStoreHash());
        $this->assertEquals($this->credentials['apiUrl'], $config->getApiBaseUrl());
        $this->assertEquals($this->logger, $connection->getLogger());
    }

    /**
     * @return string[]
     */
    private function getBasicCredential()
    {
        return $basicCredentials = [
            'storeUrl' => 'https://store-velgoi8q0k.mybigcommerce.com',
            'username' => 'test',
            'apiKey' => '2525df56477f58e5868c240ee5228b0b5d4367c4'
        ];
    }

    /**
     * @return string[]
     */
    private function getAuthCredential()
    {
        return $authCredentials = [
            'clientId' => 'acxu0p8rfh15m8n0fn4obuxmb52tgwk',
            'authToken' => 'cyfbhepc71mns8xnykv86wruxzh45wi',
            'storeHash' => 'e87g0h02r5',
            'apiUrl' => 'https://api.service.bcdev',
            'paymentUrl' => 'https://api.service.bcdev'
        ];
    }

    /**
     * @return array
     */
    private function getOptions()
    {
        return $options = [
            'verify' => false,
            'timeout' => 60,
            'accept' => 'application/json',
            'debug' => true,
            'proxy' => 'tcp:localhost:8080'
        ];
    }

}