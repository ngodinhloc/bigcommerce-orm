<?php
declare(strict_types=1);

namespace Tests;

use Bigcommerce\ORM\Cache\FileCache\FileCachePool;
use Bigcommerce\ORM\Client\AuthConfig;
use Bigcommerce\ORM\Client\BasicConfig;
use Bigcommerce\ORM\Client\Client;
use Bigcommerce\ORM\Configuration;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Exceptions\ConfigException;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ConfigurationTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Configuration */
    protected $configuration;

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

    protected function setUp(): void
    {
        parent::setUp();
        $this->cache = $this->prophet->prophesize(FileCachePool::class)->reveal();
        $this->dispatcher = $this->prophet->prophesize(EventDispatcher::class)->reveal();
        $this->logger = $this->prophet->prophesize(Logger::class)->reveal();
        $this->options = $this->getOptions();
    }

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
     * @throws \Bigcommerce\ORM\Exceptions\ConfigException
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
     * @throws \Bigcommerce\ORM\Exceptions\ConfigException
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

        /** @var BasicConfig $config */
        $config = $client->getConfig();
        $this->assertInstanceOf(BasicConfig::class, $config);
        $this->assertEquals($this->credentials['storeUrl'], $config->getCredential()->getStoreUrl());
        $this->assertEquals($this->credentials['username'], $config->getCredential()->getUsername());
        $this->assertEquals($this->credentials['apiKey'], $config->getCredential()->getApiKey());
        $this->assertEquals($this->logger, $client->getLogger());
    }

    /**
     * @covers \Bigcommerce\ORM\Configuration::__construct
     * @covers \Bigcommerce\ORM\Configuration::configEntityManager
     * @throws \Bigcommerce\ORM\Exceptions\ConfigException
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

        /** @var AuthConfig $config */
        $config = $client->getConfig();
        $this->assertInstanceOf(AuthConfig::class, $config);
        $this->assertEquals($this->credentials['clientId'], $config->getCredential()->getClientId());
        $this->assertEquals($this->credentials['authToken'], $config->getCredential()->getAuthToken());
        $this->assertEquals($this->credentials['storeHash'], $config->getCredential()->getStoreHash());
        $this->assertEquals($this->credentials['apiUrl'], $config->getCredential()->getApiBaseUrl());
        $this->assertEquals($this->logger, $client->getLogger());
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
