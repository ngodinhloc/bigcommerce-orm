<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

use Bigcommerce\ORM\Cache\FileCache\FileCacheItem;
use Bigcommerce\ORM\Client\Exceptions\ClientException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Client
 * @package Bigcommerce\ORM\Client
 */
class Client implements ClientInterface
{
    /** @var \Bigcommerce\ORM\Client\Connection */
    protected $connection;

    /** @var \Psr\Cache\CacheItemPoolInterface */
    protected $cachePool;

    /** @var \Psr\Log\LoggerInterface */
    protected $logger;

    const LOG_QUERY_START = 'Start querying objects. Query: %s';
    const LOG_QUERY_FINISH = 'Finish querying objects. Query: %s';
    const LOG_UPDATE_START = 'Start updating objects. Path: %s .Data: %s';
    const LOG_UPDATE_FINISH = 'Finish updating objects. Path: %s .Data: %s';
    const LOG_CREATE_START = 'Start creating objects. Path: %s. Data: %s';
    const LOG_CREATE_FINISH = 'Finish creating objects. Path: %s. Data: %s';

    /**
     * Client constructor.
     * @param \Bigcommerce\ORM\Client\Connection|null $connection
     * @param \Psr\Cache\CacheItemPoolInterface|null $cachePool
     * @param \Psr\Log\LoggerInterface|null $logger
     */
    public function __construct(Connection $connection = null, CacheItemPoolInterface $cachePool = null, LoggerInterface $logger = null)
    {
        $this->connection = $connection;
        $this->cachePool = $cachePool;
        $this->logger = $logger;
    }

    /**
     * @param string|null $query
     * @return int|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function count(string $query = null)
    {
        return $this->query($query, Result::RETURN_TYPE_COUNT);
    }

    /**
     * @param string|null $query
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function findAll(string $query = null)
    {
        return $this->query($query, Result::RETURN_TYPE_ALL);
    }

    /**
     * @param string|null $query
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function findBy(string $query = null)
    {
        return $this->query($query, Result::RETURN_TYPE_ALL);
    }

    /**
     * @param string|null $query
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function find(string $query = null)
    {
        return $this->query($query, Result::RETURN_TYPE_FIRST);
    }

    /**
     * @param string|null $path
     * @param array|null $data
     * @param array|null $files
     * @return array
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function create(string $path = null, array $data = null, array $files = null)
    {
        $this->checkPath($path);

        if ($this->logger) {
            $this->logger->debug(sprintf(self::LOG_CREATE_START, $path, json_encode($data)));
        }

        try {
            $response = $this->connection->create($path, $data, $files);
        } catch (GuzzleException $e) {
            $content = $e->getResponse()->getBody()->getContents();
            throw new ClientException(ClientException::MSG_FAILED_TO_CREATE_OBJECT . $content);
        } catch (Exception $e) {
            throw new ClientException(ClientException::MSG_FAILED_TO_CREATE_OBJECT . $e->getMessage());
        }

        if ($this->logger) {
            $this->logger->debug(sprintf(self::LOG_CREATE_FINISH, $path, json_encode($data)));
        }

        return (new Result($response))->get(Result::RETURN_TYPE_ONE);
    }

    /**
     * @param string|null $path
     * @param array|null $data
     * @param string|null $file
     * @return array|false
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function update(string $path = null, array $data = null, string $file = null)
    {
        $this->checkPath($path);

        if (empty($data)) {
            return true;
        }

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(self::LOG_UPDATE_START, $path, json_encode($data)));
        }

        try {
            $response = $this->connection->update($path, $data, $file);
        } catch (GuzzleException $e) {
            $content = $e->getResponse()->getBody()->getContents();
            throw new ClientException(ClientException::MSG_FAILED_TO_UPDATE_OBJECT . $content);
        } catch (Exception $e) {
            throw new ClientException(ClientException::MSG_FAILED_TO_UPDATE_OBJECT . $e->getMessage());
        }

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(self::LOG_UPDATE_FINISH, $path, json_encode($data)));
        }

        return (new Result($response))->get(Result::RETURN_TYPE_ONE);
    }

    /**
     * @param string|null $query
     * @param string|null $returnType
     * @return array|bool|int|mixed
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    private function query(string $query = null, string $returnType = null)
    {
        $this->checkPath($query);

        if ($this->hasCachePool()) {
            $cacheItem = $this->cachePool->getItem($query);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }
        }

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(self::LOG_QUERY_START, $query));
        }

        try {
            $response = $this->connection->query($query);
        } catch (GuzzleException $e) {
            $content = $e->getResponse()->getBody()->getContents();
            throw new ClientException(ClientException::MSG_FAILED_TO_QUERY_OBJECT . $content);
        } catch (\Exception $e) {
            throw new ClientException(ClientException::MSG_FAILED_TO_QUERY_OBJECT . $e->getMessage());
        }

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(self::LOG_QUERY_FINISH, $query));
        }

        $result = (new Result($response))->get($returnType);

        if ($this->hasCachePool()) {
            $data = [
                'key' => $query,
                'value' => $result,
            ];
            $cacheItem = new FileCacheItem($data);
            $this->cachePool->save($cacheItem);
        }

        return $result;
    }

    /**
     * @return bool
     */
    private function hasLogger(){
        return ($this->logger instanceof LoggerInterface);
    }

    /**
     * @return bool
     */
    private function hasCachePool(){
        return ($this->cachePool instanceof CacheItemPoolInterface);
    }

    /**
     * @param string|null $path
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     */
    private function checkPath(string $path = null)
    {
        if (empty($path)) {
            throw new ClientException(ClientException::MSG_QUERY_MISSING);
        }
    }

    /**
     * @return \Bigcommerce\ORM\Client\Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param \Bigcommerce\ORM\Client\Connection $connection
     * @return \Bigcommerce\ORM\Client\Client
     */
    public function setConnection(Connection $connection): Client
    {
        $this->connection = $connection;
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
     * @param \Psr\Cache\CacheItemPoolInterface $cachePool
     * @return \Bigcommerce\ORM\Client\Client
     */
    public function setCachePool(CacheItemPoolInterface $cachePool): Client
    {
        $this->cachePool = $cachePool;
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
     * @param \Psr\Log\LoggerInterface $logger
     * @return \Bigcommerce\ORM\Client\Client
     */
    public function setLogger(LoggerInterface $logger): Client
    {
        $this->logger = $logger;
        return $this;
    }
}
