<?php

namespace Bigcommerce\ORM\Client;

use Bigcommerce\ORM\Config\ConfigOption;

class RequestOption
{
    /** @var \Bigcommerce\ORM\Client\AbstractConfig */
    protected $config;

    /** @var array */
    protected $headers = [];

    /** @var array */
    protected $options = [];

    public function __construct(AbstractConfig $config = null)
    {
        $this->config = $config;
        $this->initialiseHeaders();
        $this->initialiseOptions();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        if (!empty($this->headers)) {
            $this->options['headers'] = $this->headers;
        }

        return $this->options;
    }

    /**
     * Add a custom header to the request.
     *
     * @param string $header
     * @param string $value
     * @return \Bigcommerce\ORM\Client\RequestOption
     */
    public function addRequestHeader(string $header, string $value)
    {
        $this->headers[$header] = $value;

        return $this;
    }

    /**
     * @param array $body
     * @return \Bigcommerce\ORM\Client\RequestOption
     */
    public function addRequestBody(array $body)
    {
        $this->options['body'] = json_encode($body);

        return $this;
    }

    /**
     * @param array $files
     * @return \Bigcommerce\ORM\Client\RequestOption
     */
    public function addRequestFiles(array $files)
    {
        if(empty($files)){
            return $this;
        }

        $multi = [];
        foreach ($files as $field => $location) {
            $multi[] = [
                'name' => $field,
                'filename' => $location,
                'contents' => file_get_contents($location)
            ];
        }

        $this->options['multipart'] = $multi;
        /** when using multipart, guzzle takes care what header Content-Type to use */
        unset($this->headers['Content-Type']);

        return $this;
    }

    private function initialiseHeaders()
    {
        $this->addRequestHeader('Content-Type', ConfigOption::CONTENT_TYPE_JSON);
        if (!empty($authHeaders = $this->config->getAuthHeaders())) {
            foreach ($authHeaders as $header => $value) {
                $this->addRequestHeader($header, $value);
            }
        }

        if (!empty($this->config->getConfigOption()->getAccept())) {
            $this->addRequestHeader('Accept', $this->config->getConfigOption()->getAccept());
        }
    }

    private function initialiseOptions()
    {
        if ($auth = $this->config->getAuth()) {
            $this->options['auth']  = $auth;
        }

        if ($proxy = $this->config->getConfigOption()->getProxy()) {
            $this->options['proxy']  = $proxy;
        }

        if (is_int($timeout = $this->config->getConfigOption()->getTimeout())) {
            $this->options['connect_timeout']  = $timeout;
        }

        if ($this->config->getConfigOption()->isVerify() === true) {
            $this->options['verify']= true;
        }

        if ($this->config->getConfigOption()->isDebug() === true) {
            $this->options['debug']  = true;
        }
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
     * @return \Bigcommerce\ORM\Client\RequestOption
     */
    public function setConfig(\Bigcommerce\ORM\Client\AbstractConfig $config): RequestOption
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return \Bigcommerce\ORM\Client\RequestOption
     */
    public function setHeaders(array $headers): RequestOption
    {
        $this->headers = $headers;

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
     * @return \Bigcommerce\ORM\Client\RequestOption
     */
    public function setOptions(array $options): RequestOption
    {
        $this->options = $options;

        return $this;
    }
}
