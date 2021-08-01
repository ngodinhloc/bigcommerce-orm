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

    /** @var array */
    protected $requestOptions;

    /** @var string */
    protected $apiUrl;

    /** @var string */
    protected $paymentUrl;

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
     * @param \Psr\Log\LoggerInterface|null $logger
     * @param \GuzzleHttp\Client|null $client
     */
    public function __construct(?AbstractConfig $config = null, ?LoggerInterface $logger = null, ?Client $client = null)
    {
        $this->config = $config;
        $this->logger = $logger;
        $this->client = $client ?: new Client();
        $this->setup();
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(?string $path, ?string $resourceType, ?array $body, ?array $file): ResponseInterface
    {
        return $this->post($path, $resourceType, $body, $file);
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(?string $path, ?string $resourceType)
    {
        $apiUrl = $this->getApiFullUrl($path, $resourceType);

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(LogMessage::LOG_REQUEST_START, 'DELETE', $apiUrl, json_encode($this->requestOptions)));
        }

        $result = $this->client->delete($apiUrl, $this->requestOptions);

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(LogMessage::LOG_REQUEST_FINISH, 'DELETE', $apiUrl, json_encode($this->requestOptions)));
        }

        return $result;
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function get(?string $path, ?string $resourceType)
    {
        $apiUrl = $this->getApiFullUrl($path, $resourceType);

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(LogMessage::LOG_REQUEST_START, 'GET', $apiUrl, json_encode($this->requestOptions)));
        }

        $result = $this->client->get($apiUrl, $this->requestOptions);

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(LogMessage::LOG_REQUEST_FINISH, 'GET', $apiUrl, json_encode($this->requestOptions)));
        }

        return $result;
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @return string
     */
    private function getApiFullUrl(?string $path, ?string $resourceType)
    {
        switch ($resourceType) {
            case AbstractConfig::RESOURCE_TYPE_PAYMENT:
                return $this->paymentUrl . $path;
            case AbstractConfig::RESOURCE_TYPE_API:
            default:
                return $this->apiUrl . $path;
        }
    }

    /**
     * @param string|null $path
     * @param string|null $resourceType
     * @param array|null $body
     * @param array|null $files
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function post(?string $path, ?string $resourceType, ?array $body, ?array $files)
    {
        if (!empty($body)) {
            $this->addRequestBody($body);
        }

        if (!empty($files)) {
            $this->addRequestFile($files);
        }

        $apiUrl = $this->getApiFullUrl($path, $resourceType);

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(LogMessage::LOG_REQUEST_START, 'POST', $apiUrl, json_encode($this->requestOptions)));
        }

        $result = $this->client->post($apiUrl, $this->requestOptions);

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(LogMessage::LOG_REQUEST_FINISH, 'POST', $apiUrl, json_encode($this->requestOptions)));
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
            $this->addRequestBody($body);
        }

        if (!empty($files)) {
            $this->addRequestFile($files);
        }

        $apiUrl = $this->getApiFullUrl($path, $resourceType);

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(LogMessage::LOG_REQUEST_START, 'PUT', $apiUrl, json_encode($this->requestOptions)));
        }

        $result = $this->client->put($apiUrl, $this->requestOptions);

        if ($this->hasLogger()) {
            $this->logger->debug(sprintf(LogMessage::LOG_REQUEST_FINISH, 'PUT', $apiUrl, json_encode($this->requestOptions)));
        }

        return $result;
    }

    /**
     * Setup connection
     */
    private function setup()
    {
        $this->apiUrl = $this->config->getApiUrl();
        $this->paymentUrl = $this->config->getPaymentUrl();
        $this->addRequestHeader('Content-Type', ConfigOption::CONTENT_TYPE_JSON);

        if (!empty($auth = $this->config->getAuth())) {
            $this->auth = $auth;
        }

        if (!empty($authHeaders = $this->config->getAuthHeaders())) {
            foreach ($authHeaders as $header => $value) {
                $this->addRequestHeader($header, $value);
            }
        }

        if (!empty($this->config->getConfigOption()->getAccept())) {
            $this->addRequestHeader('Accept', $this->config->getConfigOption()->getAccept());
        }

        if (!empty($this->config->getConfigOption()->getTimeout())) {
            $this->timeout = $this->config->getConfigOption()->getTimeout();
        }

        if (!empty($this->config->getConfigOption()->isVerify())) {
            $this->verify = $this->config->getConfigOption()->isVerify();
        }

        if (!empty($this->config->getConfigOption()->getProxy())) {
            $this->proxy = $this->config->getConfigOption()->getProxy();
        }

        if ($this->config->getConfigOption()->isDebug() == true) {
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
        /** when upload file, guzzle takes care what header Content-Type to use */
        unset($this->requestOptions['headers']['Content-Type']);
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
     * @return array
     */
    public function getRequestOptions(): array
    {
        return $this->requestOptions;
    }

    /**
     * Connection need PaymentAccessToken in order to work with payment API
     * Payment API only accept 'application/vnd.bc.v1+json'
     * @param string|null $token
     * @return \Bigcommerce\ORM\Client\Connection
     */
    public function setPaymentAccessToken(?string $token)
    {
        $this->addRequestHeader('Authorization', "PAT $token");
        $this->addRequestHeader('Accept', ConfigOption::CONTENT_TYPE_BCV1);
        $this->composeRequestOptions();

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
