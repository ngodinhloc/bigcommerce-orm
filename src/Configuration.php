<?php

declare(strict_types=1);

namespace Bigcommerce\ORM;

use Bigcommerce\ORM\Client\AuthConfig;
use Bigcommerce\ORM\Client\BasicConfig;
use Bigcommerce\ORM\Client\Client;
use Bigcommerce\ORM\Config\AuthCredential;
use Bigcommerce\ORM\Config\BasicCredential;
use Bigcommerce\ORM\Config\ConfigOption;
use Bigcommerce\ORM\Exceptions\ConfigException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Configuration
{
    protected array $credentials;
    protected array $options;
    protected \Psr\Cache\CacheItemPoolInterface $cachePool;
    protected \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher;
    protected \Psr\Log\LoggerInterface $logger;

    /**
     * Configuration constructor.
     * @param array|null $credentials
     * [
     *  'storeUrl' => ''
     *  'username' => ''
     *  'apiKey' => ''
     * ]
     * or
     * [
     *  'clientId' => ''
     *  'authToken' => ''
     *  'storeHash' => ''
     * ]
     * @param array|null $options
     * [
     *  'proxy' => 'tcp://localhost:8125'
     *  'verify' => true|false
     *  'timeout' => 60
     *  'accept' => 'application/json'
     *  'debug' => true
     * ]
     * @param \Psr\Cache\CacheItemPoolInterface|null
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface|null
     * @param \Psr\Log\LoggerInterface|null
     * @see \Bigcommerce\ORM\Client\BasicConfig::__construct
     * @see \Bigcommerce\ORM\Client\AuthConfig::__construct
     */
    public function __construct(
        ?array $credentials = null,
        ?array $options = null,
        ?CacheItemPoolInterface $cachePool = null,
        ?EventDispatcherInterface $eventDispatcher = null,
        ?LoggerInterface $logger = null
    ) {
        $this->credentials = $credentials;
        $this->options = $options;
        $this->cachePool = $cachePool;
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ConfigException
     */
    public function configEntityManager()
    {
        $configOption = new ConfigOption($this->options);
        if (isset($this->credentials['clientId'])) {
            $authCredential = new AuthCredential($this->credentials);
            $config = new AuthConfig($authCredential, $configOption);
        } elseif (isset($this->credentials['storeUrl'])) {
            $basicCredential = new BasicCredential($this->credentials);
            $config = new BasicConfig($basicCredential, $configOption);
        } else {
            throw new ConfigException(
                ConfigException::ERROR_MISSING_CONFIG . implode(",", BasicCredential::REQUIRED_CONFIGURATION_DATA)
                .' or '.implode(",", AuthCredential::REQUIRED_CONFIGURATION_DATA)
            );
        }

        $client = new Client($config, null, $this->logger, $this->cachePool);

        return new EntityManager($client, null, $this->eventDispatcher);
    }

    /**
     * @return array
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @param array|null $credentials
     * @return \Bigcommerce\ORM\Configuration
     */
    public function setCredentials(?array $credentials): Configuration
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array|null $options
     * @return \Bigcommerce\ORM\Configuration
     */
    public function setOptions(?array $options): Configuration
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return \Psr\Cache\CacheItemPoolInterface
     */
    public function getCachePool()
    {
        return $this->cachePool;
    }

    /**
     * @param \Psr\Cache\CacheItemPoolInterface|null $cachePool
     * @return \Bigcommerce\ORM\Configuration
     */
    public function setCachePool(?CacheItemPoolInterface $cachePool): Configuration
    {
        $this->cachePool = $cachePool;

        return $this;
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface|null $eventDispatcher
     * @return \Bigcommerce\ORM\Configuration
     */
    public function setEventDispatcher(?EventDispatcherInterface $eventDispatcher): Configuration
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param \Psr\Log\LoggerInterface|null $logger
     * @return \Bigcommerce\ORM\Configuration
     */
    public function setLogger(?LoggerInterface $logger): Configuration
    {
        $this->logger = $logger;

        return $this;
    }
}
