<?php

namespace Bigcommerce\ORM\Config;

class ConfigOption
{
    const API_VERSION_V3 = "v3";
    const CONTENT_TYPE_JSON = 'application/json';
    const CONTENT_TYPE_BCV1 = 'application/vnd.bc.v1+json';
    const CONTENT_TYPE_WWW = 'application/x-www-form-urlencoded';

    /** @var bool */
    protected $verify = false;

    /** @var float */
    protected $timeout = 60;

    /** @var string */
    protected $accept = self::CONTENT_TYPE_JSON;

    /** @var bool */
    protected $debug = false;

    /** @var string */
    protected $apiVersion = self::API_VERSION_V3;

    /** @var string|null */
    protected $proxy;

    public function __construct(array $options = null)
    {
        if (isset($options['timeout'])) {
            $this->timeout = $options['timeout'];
        }

        if (isset($options['verify'])) {
            $this->verify = $options['verify'];
        }

        if (isset($options['debug'])) {
            $this->debug = $options['debug'];
        }

        if (isset($options['proxy'])) {
            $this->proxy = $options['proxy'];
        }

        if (isset($options['accept'])) {
            $this->setAccept($options['accept']);
        }

        if (isset($options['apiVersion'])) {
            $this->setApiVersion($options['apiVersion']);
        }
    }

    /**
     * @return string
     */
    public function getAccept(): string
    {
        return $this->accept;
    }

    /**
     * @param string $accept
     * @return \Bigcommerce\ORM\Config\ConfigOption
     */
    public function setAccept(string $accept): ConfigOption
    {
        if (!in_array($accept, [self::CONTENT_TYPE_JSON, self::CONTENT_TYPE_BCV1, self::CONTENT_TYPE_WWW])) {
            return $this;
        }

        $this->accept = $accept;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     * @return \Bigcommerce\ORM\Config\ConfigOption
     */
    public function setTimeout(int $timeout): ConfigOption
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @return bool
     */
    public function isVerify(): bool
    {
        return $this->verify;
    }

    /**
     * @param bool $verify
     * @return \Bigcommerce\ORM\Config\ConfigOption
     */
    public function setVerify(bool $verify): ConfigOption
    {
        $this->verify = $verify;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     * @return \Bigcommerce\ORM\Config\ConfigOption
     */
    public function setDebug(bool $debug): ConfigOption
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProxy(): ?string
    {
        return $this->proxy;
    }

    /**
     * @param string $proxy
     * @return \Bigcommerce\ORM\Config\ConfigOption
     */
    public function setProxy(string $proxy): ConfigOption
    {
        $this->proxy = $proxy;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * @param string|null $apiVersion
     * @return \Bigcommerce\ORM\Config\ConfigOption
     */
    public function setApiVersion(?string $apiVersion): ConfigOption
    {
        /** Only support API V3 */
        if (!in_array($apiVersion, [self::API_VERSION_V3])) {
            return $this;
        }

        $this->apiVersion = $apiVersion;

        return $this;
    }
}
