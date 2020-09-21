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

    const LOG_QUERY_START = 'Start querying objects. Resource type: %s. Query: %s';
    const LOG_QUERY_FINISH = 'Finish querying objects. Resource type: %s. Query: %s';
    const LOG_UPDATE_START = 'Start updating objects. Resource type: %s. Path: %s .Data: %s';
    const LOG_UPDATE_FINISH = 'Finish updating objects. Resource type: %s. Path: %s .Data: %s';
    const LOG_CREATE_START = 'Start creating objects. Resource type: %s. Path: %s. Data: %s';
    const LOG_CREATE_FINISH = 'Finish creating objects. Resource type: %s. Path: %s. Data: %s';
    const LOG_DELETE_START = 'Start deleting objects. Resource type: %s. Query: %s';
    const LOG_DELETE_FINISH = 'Finish deleting objects. Resource type: %s. Query: %s';

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
     * @param string|null $resourceType
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function findAll(string $query = null, string $resourceType = null)
    {
        return $this->query($query, $resourceType, Result::RETURN_TYPE_ALL);
    }

    /**
     * @param string|null $query
     * @param string|null $resourceType
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function findBy(string $query = null, string $resourceType = null)
    {
        return $this->query($query, $resourceType, Result::RETURN_TYPE_ALL);
    }

    /**
     * @param string|null $query
     * @param string|null $resourceType
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function find(string $query = null, string $resourceType = null)
    {
        return $this->query($query, $resourceType, Result::RETURN_TYPE_ONE);
    }

    /**
     * @param string|null $resourcePath
     * @param string|null $resourceType
     * @param array|null $data
     * @param array|null $files
     * @param bool $batch
     * @return array
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function create(string $resourcePath = null, string $resourceType = null, array $data = null, array $files = null, bool $batch = false)
    {
        $this->checkPath($resourcePath);

        if ($this->logger) {
            $this->logger->debug(sprintf(self::LOG_CREATE_START, $resourceType, $resourcePath, json_encode($data)));
        }

        try {
            $response = $this->connection->create($resourcePath, $resourceType, $data, $files);
        } catch (GuzzleException $e) {
            $content = $e->getResponse()->getBody()->getContents();
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_CREATE_OBJECT, $resourceType, $resourcePath, json_encode($data), $content));
        } catch (Exception $e) {
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_CREATE_OBJECT, $resourceType, $resourcePath, json_encode($data), $e->getMessage()));
        }

        if ($this->logger) {
            $this->logger->debug(sprintf(self::LOG_CREATE_FINISH, $resourceType, $resourcePath, json_encode($data)));
        }

        if ($batch == true) {
            return (new Result($response))->get(Result::RETURN_TYPE_ALL);
        }

        return (new Result($response))->get(Result::RETURN_TYPE_ONE);
    }

    /**
     * @param string|null $resourcePath
     * @param string|null $resourceType
     * @param array|null $data
     * @param array|null $files
     * @param bool $batch
     * @return array|false
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function update(string $resourcePath = null, string $resourceType = null, array $data = null, array $files = null, bool $batch = false)
    {
        $this->checkPath($resourcePath);

        if (empty($data)) {
            return true;
        }

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(self::LOG_UPDATE_START, $resourceType, $resourcePath, json_encode($data)));
        }

        try {
            $response = $this->connection->update($resourcePath, $resourceType, $data, $files);
        } catch (GuzzleException $e) {
            $content = $e->getResponse()->getBody()->getContents();
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_UPDATE_OBJECT, $resourceType, $resourcePath, json_encode($data), $content));
        } catch (Exception $e) {
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_UPDATE_OBJECT, $resourceType, $resourcePath, json_encode($data), $e->getMessage()));
        }

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(self::LOG_UPDATE_FINISH, $resourceType, $resourcePath, json_encode($data)));
        }

        if ($batch == true) {
            return (new Result($response))->get(Result::RETURN_TYPE_ALL);
        }

        return (new Result($response))->get(Result::RETURN_TYPE_ONE);
    }

    /**
     * @param string|null $resourcePath
     * @param string|null $resourceType
     * @return array|bool|int
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function delete(string $resourcePath = null, string $resourceType = null)
    {
        $this->checkPath($resourcePath);

        if ($this->logger) {
            $this->logger->debug(sprintf(self::LOG_DELETE_START, $resourceType, $resourcePath));
        }

        try {
            $response = $this->connection->delete($resourcePath, $resourceType);
        } catch (GuzzleException $e) {
            $content = $e->getResponse()->getBody()->getContents();
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_DELETE_OBJECT, $resourceType, $resourcePath, $content));
        } catch (Exception $e) {
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_DELETE_OBJECT, $resourceType, $resourcePath, $e->getMessage()));
        }

        if ($this->logger) {
            $this->logger->debug(sprintf(self::LOG_DELETE_FINISH, $resourceType, $resourcePath));
        }

        return (new Result($response))->get(Result::RETURN_TYPE_BOOL);
    }

    /**
     * @param string|null $query
     * @param string|null $returnType
     * @param string|null $resourceType
     * @return array|bool|int|mixed
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    private function query(string $query = null, string $resourceType = null, string $returnType = null)
    {
        $this->checkPath($query);

        if ($this->hasCachePool()) {
            $cacheItem = $this->cachePool->getItem($query);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }
        }

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(self::LOG_QUERY_START, $resourceType, $query));
        }

        try {
            $response = $this->connection->query($query, $resourceType);
        } catch (GuzzleException $e) {
            $content = $e->getResponse()->getBody()->getContents();
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_QUERY_OBJECT, $resourceType, $query, $content));
        } catch (\Exception $e) {
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_QUERY_OBJECT, $resourceType, $query, $e->getMessage()));
        }

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(self::LOG_QUERY_FINISH, $resourceType, $query));
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
    private function hasLogger()
    {
        return ($this->logger instanceof LoggerInterface);
    }

    /**
     * @return bool
     */
    private function hasCachePool()
    {
        return ($this->cachePool instanceof CacheItemPoolInterface);
    }

    /**
     * @param string|null $path
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     */
    private function checkPath(string $path = null)
    {
        if (empty($path)) {
            throw new ClientException(ClientException::ERROR_QUERY_MISSING);
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
