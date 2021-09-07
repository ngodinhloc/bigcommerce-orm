<?php

namespace Bigcommerce\ORM\Client\Commands;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class AbstractCommand
{
    /** @var \GuzzleHttp\Client */
    protected $client;

    /** @var string */
    protected $apiUrl;

    /** @var array */
    protected $options;

    /** @var \Psr\Log\LoggerInterface */
    protected $logger;

    public function __construct(Client $client, string $apiUrl, array $options, LoggerInterface $logger = null)
    {
        $this->client = $client;
        $this->apiUrl = $apiUrl;
        $this->options = $options;
        $this->logger = $logger;
    }

    /**
     * @return bool
     */
    protected function hasLogger()
    {
        return ($this->logger instanceof LoggerInterface);
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param \GuzzleHttp\Client $client
     * @return \Bigcommerce\ORM\Client\Commands\AbstractCommand
     */
    public function setClient(Client $client): AbstractCommand
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * @param string $apiUrl
     * @return \Bigcommerce\ORM\Client\Commands\AbstractCommand
     */
    public function setApiUrl(string $apiUrl): AbstractCommand
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return \Bigcommerce\ORM\Client\Commands\AbstractCommand
     */
    public function setOptions(array $options): AbstractCommand
    {
        $this->options = $options;

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
     * @return \Bigcommerce\ORM\Client\Commands\AbstractCommand
     */
    public function setLogger(LoggerInterface $logger): AbstractCommand
    {
        $this->logger = $logger;

        return $this;
    }
}
