<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

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

    /** @var array */
    protected $requestOptions;

    /** @var string */
    protected $apiUrl;

    /** @var array */
    protected $auth = [];

    /** @var array */
    protected $headers = [];

    /** @var float */
    protected $timeout = 60;

    /** @var string */
    protected $proxy;

    /** @var bool */
    protected $verify = false;

    /** @var bool */
    protected $debug = false;

    /**
     * Connection constructor.
     * @param \Bigcommerce\ORM\Client\AbstractConfig|null $config
     * @param \GuzzleHttp\Client|null $client
     */
    public function __construct(AbstractConfig $config = null, Client $client = null)
    {
        $this->config = $config;
        $this->client = $client ?: new Client();
        $this->setup();
    }

    /**
     * @param string|null $path
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function query(string $path = null): ResponseInterface
    {
        return $this->get($path);
    }

    /**
     * @param string|null $path
     * @param array|null $body
     * @param array|null $files
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(string $path = null, array $body = null, array $files = null): ResponseInterface
    {
        return $this->put($path, $body, $files);
    }

    /**
     * @param string|null $path
     * @param array|null $body
     * @param array|null $file
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(string $path = null, array $body = null, array $file = null): ResponseInterface
    {
        return $this->post($path, $body, $file);
    }

    /**
     * @param string|null $path
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function get(string $path = null)
    {
        return $this->client->get($this->apiUrl . $path, $this->requestOptions);
    }

    /**
     * @param string|null $path
     * @param array|null $body
     * @param array|null $files
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function post(string $path = null, array $body = null, array $files = null)
    {
        if (!empty($body)) {
            $this->addRequestBody($body);
        }

        if (!empty($files)) {
            $this->addRequestFile($files);
        }

        return $this->client->post($this->apiUrl . $path, $this->requestOptions);
    }

    /**
     * @param string|null $path
     * @param array|null $body
     * @param array|null $files
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function put(string $path = null, array $body = null, array $files = null)
    {
        if (!empty($body)) {
            $this->addRequestBody($body);
        }

        if (!empty($files)) {
            $this->addRequestFile($files);
        }

        return $this->client->put($this->apiUrl . $path, $this->requestOptions);
    }

    /**
     * Setup connection
     */
    private function setup()
    {
        $this->apiUrl = $this->config->getApiUrl();

        if ($this->config instanceof BasicConfig) {
            $this->auth = [$this->config->getUsername(), $this->config->getApiKey()];

        }

        if ($this->config instanceof AuthConfig) {
            $this->addRequestHeader('X-Auth-Client', $this->config->getClientId());
            $this->addRequestHeader('X-Auth-Token', $this->config->getAuthToken());
        }

        if (!empty($this->config->getContentType())) {
            $this->addRequestHeader('Accept', $this->config->getContentType());
        }

        if (!empty($this->config->getTimeout())) {
            $this->timeout = $this->config->getTimeout();
        }

        if (!empty($this->config->isVerify())) {
            $this->verify = $this->config->isVerify();
        }

        if (!empty($this->config->getProxy())) {
            $this->proxy = $this->config->getProxy();
        }
        if ($this->config->isDebug() == true) {
            $this->debug = true;
        }

        $this->composeRequestOptions();
    }

    /**
     * Set request options
     */
    private function composeRequestOptions()
    {
        $this->requestOptions = [];

        if (!empty($this->auth)) {
            $this->requestOptions['auth'] = $this->auth;
        }

        if (!empty($this->headers)) {
            $this->requestOptions['headers'] = $this->headers;
        }

        if (!empty($this->timeout)) {
            $this->requestOptions['connect_timeout'] = $this->timeout;
        }

        if (!empty($this->proxy)) {
            $this->requestOptions['proxy'] = $this->proxy;
        }

        if (!empty($this->verify)) {
            $this->requestOptions['verify'] = true;
        }

        if (!empty($this->debug)) {
            $this->requestOptions['debug'] = true;
        }
    }

    /**
     * Add a custom header to the request.
     *
     * @param string $header
     * @param string $value
     */
    private function addRequestHeader(string $header, string $value)
    {
        $this->headers[$header] = $value;
    }

    /**
     * @param array $body
     */
    private function addRequestBody(array $body)
    {
        $this->requestOptions['body'] = json_encode($body);
    }

    /**
     * @param array $files
     */
    private function addRequestFile(array $files)
    {
        $multi = [];
        foreach ($files as $field => $location) {
            $multi[] = [
                'name' => $field,
                'filename' => $location,
                'contents' => file_get_contents($location)
            ];
        }
        $this->requestOptions['multipart'] = $multi;
    }

    /**
     * @return \Bigcommerce\ORM\Client\AbstractConfig
     */
    public function getConfig(): AbstractConfig
    {
        return $this->config;
    }

    /**
     * @param \Bigcommerce\ORM\Client\AbstractConfig $config
     * @return \Bigcommerce\ORM\Client\Connection
     */
    public function setConfig(AbstractConfig $config): Connection
    {
        $this->config = $config;
        $this->setup();

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
     * @param \GuzzleHttp\Client $client
     * @return \Bigcommerce\ORM\Client\Connection
     */
    public function setClient(Client $client): Connection
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return array
     */
    public function getRequestOptions(): array
    {
        return $this->requestOptions;
    }
}
