<?php

declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

use Bigcommerce\ORM\Cache\FileCache\FileCacheItem;
use Bigcommerce\ORM\Client\Commands\DeleteCommand;
use Bigcommerce\ORM\Client\Commands\GetCommand;
use Bigcommerce\ORM\Client\Commands\PostCommand;
use Bigcommerce\ORM\Client\Commands\PutCommand;
use Bigcommerce\ORM\Config\ConfigOption;
use Bigcommerce\ORM\Exceptions\ClientException;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Client
 * @package Bigcommerce\ORM\Client
 */
class Client implements ClientInterface
{
    protected \Bigcommerce\ORM\Client\AbstractConfig $config;
    protected \GuzzleHttp\Client $guzzleClient;
    protected \Psr\Log\LoggerInterface $logger;
    protected \Bigcommerce\ORM\Client\RequestOption $option;
    protected \Psr\Cache\CacheItemPoolInterface $cachePool;

    /**
     * Client constructor.
     * @param \Bigcommerce\ORM\Client\AbstractConfig|null $config
     * @param \GuzzleHttp\Client|null $guzzleClient
     * @param \Psr\Log\LoggerInterface|null $logger
     * @param \Psr\Cache\CacheItemPoolInterface|null $cachePool
     */
    public function __construct(
        ?AbstractConfig $config = null,
        ?\GuzzleHttp\Client $guzzleClient = null,
        ?LoggerInterface $logger = null,
        ?CacheItemPoolInterface $cachePool = null
    ) {
        $this->config = $config;
        $this->guzzleClient = $guzzleClient ?: new \GuzzleHttp\Client();
        $this->logger = $logger;
        $this->cachePool = $cachePool;
        $this->option = new RequestOption($this->config);
    }

    /**
     * @param string|null $query
     * @param string|null $resourceType
     * @return array|bool
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
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
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
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
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
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
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function create(?string $resourcePath, ?string $resourceType, ?array $data, ?array $files, bool $batch = false)
    {
        $this->checkPath($resourcePath);

        try {
            $response = $this->postCommand($resourcePath, $resourceType, $data, $files);
        } catch (GuzzleException $exception) {
            $content = $this->getGuzzleExceptionMessage($exception);
            throw new ClientException(
                sprintf(ClientException::ERROR_FAILED_TO_CREATE_OBJECT, $resourceType, $resourcePath, json_encode($data), $content)
            );
        } catch (Exception $exception) {
            throw new ClientException(
                sprintf(ClientException::ERROR_FAILED_TO_CREATE_OBJECT, $resourceType, $resourcePath, json_encode($data), $exception->getMessage())
            );
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
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function update(?string $resourcePath, ?string $resourceType, ?array $data, ?array $files, bool $batch = false)
    {
        $this->checkPath($resourcePath);

        if (empty($data)) {
            return true;
        }

        try {
            $response = $this->putCommand($resourcePath, $resourceType, $data, $files);
        } catch (GuzzleException $exception) {
            $content = $this->getGuzzleExceptionMessage($exception);
            throw new ClientException(
                sprintf(ClientException::ERROR_FAILED_TO_UPDATE_OBJECT, $resourceType, $resourcePath, json_encode($data), $content)
            );
        } catch (Exception $exception) {
            throw new ClientException(
                sprintf(ClientException::ERROR_FAILED_TO_UPDATE_OBJECT, $resourceType, $resourcePath, json_encode($data), $exception->getMessage())
            );
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
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function delete(?string $resourcePath, ?string $resourceType)
    {
        $this->checkPath($resourcePath);

        try {
            $response = $this->deleteCommand($resourcePath, $resourceType);
        } catch (GuzzleException $exception) {
            $content = $this->getGuzzleExceptionMessage($exception);
            throw new ClientException(
                sprintf(ClientException::ERROR_FAILED_TO_DELETE_OBJECT, $resourceType, $resourcePath, $content)
            );
        } catch (Exception $exception) {
            throw new ClientException(
                sprintf(ClientException::ERROR_FAILED_TO_DELETE_OBJECT, $resourceType, $resourcePath, $exception->getMessage())
            );
        }

        return (new Result($response))->get(Result::RETURN_TYPE_BOOL);
    }

    /**
     * @param string|null $query
     * @param string|null $returnType
     * @param string|null $resourceType
     * @return array|bool|int|mixed
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    private function query(?string $query, ?string $resourceType, ?string $returnType)
    {
        $this->checkPath($query);

        $cacheItem = $this->getCache($query);
        if ($cacheItem instanceof CacheItemInterface && $cacheItem->isHit()) {
            return $cacheItem->get();
        }

        try {
            $response = $this->getCommand($query, $resourceType);
        } catch (GuzzleException $exception) {
            $content = $this->getGuzzleExceptionMessage($exception);
            throw new ClientException(
                sprintf(ClientException::ERROR_FAILED_TO_QUERY_OBJECT, $resourceType, $query, $content)
            );
        } catch (\Exception $exception) {
            throw new ClientException(
                sprintf(ClientException::ERROR_FAILED_TO_QUERY_OBJECT, $resourceType, $query, $exception->getMessage())
            );
        }

        $result = (new Result($response))->get($returnType);
        $this->saveCache(['key' => $query, 'value' => $result]);

        return $result;
    }

    /**
     * Connection need PaymentAccessToken in order to work with payment API
     * Payment API only accept 'application/vnd.bc.v1+json'
     * @param string|null $token
     * @return \Bigcommerce\ORM\Client\Client
     */
    public function setPaymentAccessToken(?string $token)
    {
        $this->option->addRequestHeader('Authorization', "PAT $token");
        $this->option->addRequestHeader('Accept', ConfigOption::CONTENT_TYPE_BCV1);

        return $this;
    }

    /**
     * @param \GuzzleHttp\Exception\GuzzleException $exception
     * @return string
     */
    private function getGuzzleExceptionMessage(GuzzleException $exception)
    {
        if (empty($content = $exception->getResponse()->getBody()->getContents())) {
            return $exception->getMessage();
        }

        return $content;
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @return string
     */
    private function apiFullUrl(?string $path, ?string $resourceType)
    {
        switch ($resourceType) {
            case AbstractConfig::RESOURCE_TYPE_PAYMENT:
                return $this->config->getPaymentUrl() . $path;
            case AbstractConfig::RESOURCE_TYPE_API:
            default:
                return $this->config->getApiUrl() . $path;
        }
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getCommand(?string $path, ?string $resourceType)
    {
        $apiUrl = $this->apiFullUrl($path, $resourceType);
        $command = new GetCommand($this->guzzleClient, $apiUrl, $this->option->toArray(), $this->logger);

        return $command->execute();
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function deleteCommand(?string $path, ?string $resourceType)
    {
        $apiUrl = $this->apiFullUrl($path, $resourceType);
        $command = new DeleteCommand($this->guzzleClient, $apiUrl, $this->option->toArray(), $this->logger);

        return $command->execute();
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @param array|null $data
     * @param array|null $files
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function putCommand(?string $path, ?string $resourceType, ?array $data, ?array $files)
    {
        if (!empty($data)) {
            $this->option->addRequestBody($data);
        }

        if (!empty($files)) {
            $this->option->addRequestFiles($files);
        }

        $apiUrl = $this->apiFullUrl($path, $resourceType);
        $command = new PutCommand($this->guzzleClient, $apiUrl, $this->option->toArray(), $this->logger);

        return $command->execute();
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @param array|null $data
     * @param array|null $files
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function postCommand(?string $path, ?string $resourceType, ?array $data, ?array $files)
    {
        if (!empty($data)) {
            $this->option->addRequestBody($data);
        }

        if (!empty($files)) {
            $this->option->addRequestFiles($files);
        }

        $apiUrl = $this->apiFullUrl($path, $resourceType);
        $command = new PostCommand($this->guzzleClient, $apiUrl, $this->option->toArray(), $this->logger);

        return $command->execute();
    }

    /**
     * @param string $query
     * @return false|\Psr\Cache\CacheItemInterface
     * @throws \Psr\Cache\InvalidArgumentException
     */
    private function getCache(string $query)
    {
        if ($this->hasCachePool()) {
            return $this->cachePool->getItem($query);
        }

        return false;
    }

    /**
     * @param array $data
     */
    private function saveCache(array $data)
    {
        if ($this->hasCachePool()) {
            $cacheItem = new FileCacheItem($data);
            $this->cachePool->save($cacheItem);
        }
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
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     */
    private function checkPath(?string $path)
    {
        if (empty($path)) {
            throw new ClientException(ClientException::ERROR_QUERY_MISSING);
        }
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
     * @return \Bigcommerce\ORM\Client\AbstractConfig
     */
    public function getConfig(): \Bigcommerce\ORM\Client\AbstractConfig
    {
        return $this->config;
    }

    /**
     * @param \Bigcommerce\ORM\Client\AbstractConfig $config
     * @return \Bigcommerce\ORM\Client\Client
     */
    public function setConfig(\Bigcommerce\ORM\Client\AbstractConfig $config): Client
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getGuzzleClient(): GuzzleClient
    {
        return $this->guzzleClient;
    }

    /**
     * @param \GuzzleHttp\Client $guzzleClient
     * @return \Bigcommerce\ORM\Client\Client
     */
    public function setGuzzleClient(GuzzleClient $guzzleClient): Client
    {
        $this->guzzleClient = $guzzleClient;

        return $this;
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger(): LoggerInterface
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

    /**
     * @return \Bigcommerce\ORM\Client\RequestOption
     */
    public function getOption(): RequestOption
    {
        return $this->option;
    }

    /**
     * @param \Bigcommerce\ORM\Client\RequestOption $option
     * @return \Bigcommerce\ORM\Client\Client
     */
    public function setOption(RequestOption $option): Client
    {
        $this->option = $option;

        return $this;
    }
}
