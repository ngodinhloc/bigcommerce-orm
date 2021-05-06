<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

use Bigcommerce\ORM\Cache\FileCache\FileCacheItem;
use Bigcommerce\ORM\Client\Exceptions\ClientException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Cache\CacheItemPoolInterface;

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

    /**
     * Client constructor.
     * @param \Bigcommerce\ORM\Client\Connection|null $connection
     * @param \Psr\Cache\CacheItemPoolInterface|null $cachePool
     */
    public function __construct(?Connection $connection = null, ?CacheItemPoolInterface $cachePool = null)
    {
        $this->connection = $connection;
        $this->cachePool = $cachePool;
    }

    /**
     * @param string|null $query
     * @param string|null $resourceType
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function findAll(?string $query, ?string $resourceType)
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
    public function findBy(?string $query, ?string $resourceType)
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
    public function find(?string $query, ?string $resourceType)
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
    public function create(?string $resourcePath, ?string $resourceType, ?array $data, ?array $files, bool $batch = false)
    {
        $this->checkPath($resourcePath);

        try {
            $response = $this->connection->create($resourcePath, $resourceType, $data, $files);
        } catch (GuzzleException $exception) {
            $content = $this->getGuzzleExceptionMessage($exception);
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_CREATE_OBJECT, $resourceType, $resourcePath, json_encode($data), $content));
        } catch (Exception $exception) {
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_CREATE_OBJECT, $resourceType, $resourcePath, json_encode($data), $exception->getMessage()));
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
    public function update(?string $resourcePath, ?string $resourceType, ?array $data, ?array $files, bool $batch = false)
    {
        $this->checkPath($resourcePath);

        if (empty($data)) {
            return true;
        }

        try {
            $response = $this->connection->update($resourcePath, $resourceType, $data, $files);
        } catch (GuzzleException $exception) {
            $content = $this->getGuzzleExceptionMessage($exception);
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_UPDATE_OBJECT, $resourceType, $resourcePath, json_encode($data), $content));
        } catch (Exception $exception) {
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_UPDATE_OBJECT, $resourceType, $resourcePath, json_encode($data), $exception->getMessage()));
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
    public function delete(?string $resourcePath, ?string $resourceType)
    {
        $this->checkPath($resourcePath);

        try {
            $response = $this->connection->delete($resourcePath, $resourceType);
        } catch (GuzzleException $exception) {
            $content = $this->getGuzzleExceptionMessage($exception);
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_DELETE_OBJECT, $resourceType, $resourcePath, $content));
        } catch (Exception $exception) {
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_DELETE_OBJECT, $resourceType, $resourcePath, $exception->getMessage()));
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
    private function query(?string $query, ?string $resourceType, ?string $returnType)
    {
        $this->checkPath($query);

        if ($this->hasCachePool()) {
            $cacheItem = $this->cachePool->getItem($query);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }
        }

        try {
            $response = $this->connection->query($query, $resourceType);
        } catch (GuzzleException $exception) {
            $content = $this->getGuzzleExceptionMessage($exception);
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_QUERY_OBJECT, $resourceType, $query, $content));
        } catch (\Exception $exception) {
            throw new ClientException(sprintf(ClientException::ERROR_FAILED_TO_QUERY_OBJECT, $resourceType, $query, $exception->getMessage()));
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
    private function hasCachePool()
    {
        return ($this->cachePool instanceof CacheItemPoolInterface);
    }

    /**
     * @param string|null $path
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     */
    private function checkPath(?string $path)
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
     * @param \Bigcommerce\ORM\Client\Connection|null $connection
     * @return \Bigcommerce\ORM\Client\Client
     */
    public function setConnection(?Connection $connection): Client
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
     * @param \Psr\Cache\CacheItemPoolInterface|null $cachePool
     * @return \Bigcommerce\ORM\Client\Client
     */
    public function setCachePool(?CacheItemPoolInterface $cachePool): Client
    {
        $this->cachePool = $cachePool;

        return $this;
    }

    /**
     * @param string|null $token
     * @return \Bigcommerce\ORM\Client\Client
     */
    public function setPaymentAccessToken(?string $token)
    {
        $this->connection->setPaymentAccessToken($token);

        return $this;
    }

    /**
     * @param \GuzzleHttp\Exception\GuzzleException $exception
     * @return string
     */
    private function getGuzzleExceptionMessage(GuzzleException $exception){
        if(empty($exception->getResponse()->getBody()->getContents())){
            return $exception->getMessage();
        }

        return $exception->getResponse()->getBody()->getContents();
    }
}
