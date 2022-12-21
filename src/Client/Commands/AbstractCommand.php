<?php

namespace Bigcommerce\ORM\Client\Commands;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class AbstractCommand
{
    protected \GuzzleHttp\Client $client;
    protected string $apiUrl;
    protected array $options;
    protected \Psr\Log\LoggerInterface $logger;

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
}
