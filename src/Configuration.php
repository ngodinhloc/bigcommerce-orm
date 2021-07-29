<?php
declare(strict_types=1);

namespace Bigcommerce\ORM;

use Bigcommerce\ORM\Client\AuthConfig;
use Bigcommerce\ORM\Client\BasicConfig;
use Bigcommerce\ORM\Client\Client;
use Bigcommerce\ORM\Client\Connection;
use Bigcommerce\ORM\Exceptions\ConfigException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Configuration
{
    /** @var array */
    protected $credentials;

    /** @var array */
    protected $options;

    /** @var \Psr\Cache\CacheItemPoolInterface */
    protected $cachePool;

    /** @var \Symfony\Component\EventDispatcher\EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var \Psr\Log\LoggerInterface */
    protected $logger;

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
    )
    {
        $this->credentials = $credentials;
        $this->options = $options;
        $this->cachePool = $cachePool;
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ConfigException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function configEntityManager()
    {
        if (isset($this->credentials['clientId'])) {
            $config = new AuthConfig($this->credentials);
        } elseif (isset($this->credentials['storeUrl'])) {
            $config = new BasicConfig($this->credentials);
        } else {
            throw new ConfigException(ConfigException::ERROR_MISSING_CONFIG);
        }

        if (isset($this->options['proxy'])) {
            $config->setProxy($this->options['proxy']);
        }

        if (isset($this->options['verify'])) {
            $config->setVerify($this->options['verify']);
        }

        if (isset($this->options['timeout'])) {
            $config->setTimeout($this->options['timeout']);
        }

        if (isset($this->options['accept'])) {
            $config->setAccept($this->options['accept']);
        }

        if (isset($this->options['debug'])) {
            $config->setDebug($this->options['debug']);
        }

        $connection = new Connection($config, $this->logger);
        $client = new Client($connection, $this->cachePool);

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
