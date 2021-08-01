<?php

declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

use Bigcommerce\ORM\Config\ConfigOption;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Connection
 * @package Bigcommerce\ORM\Client
 */
class Connection
{
    /** @var \Bigcommerce\ORM\Client\AbstractConfig */
    protected $config;

    /** @var \GuzzleHttp\Client */
    protected $client;

    /** @var \Psr\Log\LoggerInterface */
    protected $logger;

    /** @var \Bigcommerce\ORM\Client\RequestOption */
    protected $option;

    /**
     * Connection constructor.
     * @param \Bigcommerce\ORM\Client\AbstractConfig|null $config
     * @param \Psr\Log\LoggerInterface|null $logger
     * @param \GuzzleHttp\Client|null $client
     */
    public function __construct(?AbstractConfig $config = null, ?LoggerInterface $logger = null, ?Client $client = null)
    {
        $this->config = $config;
        $this->logger = $logger;
        $this->client = $client ?: new Client();
        $this->option = new RequestOption($this->config);
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function query(?string $path, ?string $resourceType): ResponseInterface
    {
        return $this->get($path, $resourceType);
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @param array|null $body
     * @param array|null $files
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update(?string $path, ?string $resourceType, ?array $body, ?array $files): ResponseInterface
    {
        return $this->put($path, $resourceType, $body, $files);
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @param array|null $body
     * @param array|null $file
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create(?string $path, ?string $resourceType, ?array $body, ?array $file): ResponseInterface
    {
        return $this->post($path, $resourceType, $body, $file);
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(?string $path, ?string $resourceType)
    {
        $apiUrl = $this->apiFullUrl($path, $resourceType);

        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_START, 'DELETE', $apiUrl, json_encode($this->option->toArray()))
            );
        }

        $result = $this->client->delete($apiUrl, $this->option->toArray());

        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_FINISH, 'DELETE', $apiUrl, json_encode($this->option->toArray()))
            );
        }

        return $result;
    }

    /**
     * Connection need PaymentAccessToken in order to work with payment API
     * Payment API only accept 'application/vnd.bc.v1+json'
     * @param string|null $token
     * @return \Bigcommerce\ORM\Client\Connection
     */
    public function setPaymentAccessToken(?string $token)
    {
        $this->option->addRequestHeader('Authorization', "PAT $token");
        $this->option->addRequestHeader('Accept', ConfigOption::CONTENT_TYPE_BCV1);

        return $this;
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function get(?string $path, ?string $resourceType)
    {
        $apiUrl = $this->apiFullUrl($path, $resourceType);
        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_START, 'GET', $apiUrl, json_encode($this->option->toArray()))
            );
        }

        $result = $this->client->get($apiUrl, $this->option->toArray());
        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_FINISH, 'GET', $apiUrl, json_encode($this->option->toArray()))
            );
        }

        return $result;
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
     * @param array|null $body
     * @param array|null $files
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function post(?string $path, ?string $resourceType, ?array $body, ?array $files)
    {
        if (!empty($body)) {
            $this->option->addRequestBody($body);
        }

        if (!empty($files)) {
            $this->option->addRequestFile($files);
        }

        $apiUrl = $this->apiFullUrl($path, $resourceType);
        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_START, 'POST', $apiUrl, json_encode($this->option->toArray()))
            );
        }

        $result = $this->client->post($apiUrl, $this->option->toArray());
        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_FINISH, 'POST', $apiUrl, json_encode($this->option->toArray()))
            );
        }

        return $result;
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @param array|null $body
     * @param array|null $files
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function put(?string $path, ?string $resourceType, ?array $body, ?array $files)
    {
        if (!empty($body)) {
            $this->option->addRequestBody($body);
        }

        if (!empty($files)) {
            $this->option->addRequestFile($files);
        }

        $apiUrl = $this->apiFullUrl($path, $resourceType);
        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_START, 'PUT', $apiUrl, json_encode($this->option->toArray()))
            );
        }

        $result = $this->client->put($apiUrl, $this->option->toArray());
        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_FINISH, 'PUT', $apiUrl, json_encode($this->option->toArray()))
            );
        }

        return $result;
    }

    /**
     * @return \Bigcommerce\ORM\Client\AbstractConfig
     */
    public function getConfig(): AbstractConfig
    {
        return $this->config;
    }

    /**
     * @param \Bigcommerce\ORM\Client\AbstractConfig|null $config
     * @return \Bigcommerce\ORM\Client\Connection
     */
    public function setConfig(?AbstractConfig $config): Connection
    {
        $this->config = $config;
        $this->option = new RequestOption($config);

        return $this;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param \GuzzleHttp\Client|null $client
     * @return \Bigcommerce\ORM\Client\Connection
     */
    public function setClient(?Client $client): Connection
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return \Psr\Log\LoggerInterface|null
     */
    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param \Psr\Log\LoggerInterface|null $logger
     * @return \Bigcommerce\ORM\Client\Connection
     */
    public function setLogger(?LoggerInterface $logger): Connection
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
     * @return \Bigcommerce\ORM\Client\Connection
     */
    public function setOption(RequestOption $option): Connection
    {
        $this->option = $option;

        return $this;
    }

    /**
     * @return bool
     */
    private function hasLogger()
    {
        return ($this->logger instanceof LoggerInterface);
    }
}
