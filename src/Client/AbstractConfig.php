<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

/**
 * Class AbstractConfig
 * @package Bigcommerce\ORM\Client
 */
abstract class AbstractConfig
{
    const API_BASE_URL = 'https://api.bigcommerce.com';
    const API_VERSION_V3 = "v3";
    const PATH_PREFIX_V3 = '/api/v3';
    const STORE_PREFIX_V3 = '/stores/%s/v3';
    const CONTENT_TYPE_JSON = 'application/json';
    const CONTENT_TYPE_WWW = 'application/x-www-form-urlencoded';

    /** @var string */
    protected $apiVersion = self::API_VERSION_V3;

    /** @var string */
    protected $proxy;

    /** @var bool */
    protected $verify = false;

    /** @var float */
    protected $timeout = 60;

    /** @var string */
    protected $accept = self::CONTENT_TYPE_JSON;

    /** @var bool */
    protected $debug = false;

    /**
     * @return string
     */
    public function getApiUrl()
    {
        if ($this instanceof BasicConfig) {
            return rtrim($this->getStoreUrl(), '/') . $this->getPathPrefix();
        }

        if ($this instanceof AuthConfig) {
            return $this->getBaseUrl() . sprintf($this->getStorePrefix(), $this->getStoreHash());
        }
    }

    /**
     * @return string
     */
    public function getPathPrefix()
    {
        switch ($this->apiVersion) {
            case self::API_VERSION_V3:
            default:
                return self::PATH_PREFIX_V3;
        }
    }

    /**
     * @return string
     */
    public function getStorePrefix()
    {
        switch ($this->apiVersion) {
            case self::API_VERSION_V3:
            default:
                return self::STORE_PREFIX_V3;
        }
    }

    /**
     * @return string
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @param string $proxy
     * @return \Bigcommerce\ORM\Client\AbstractConfig
     */
    public function setProxy(string $proxy): AbstractConfig
    {
        $this->proxy = $proxy;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVerify()
    {
        return $this->verify;
    }

    /**
     * @param bool $verify
     * @return \Bigcommerce\ORM\Client\AbstractConfig
     */
    public function setVerify(bool $verify): AbstractConfig
    {
        $this->verify = $verify;
        return $this;
    }

    /**
     * @return float
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param float $timeout
     * @return \Bigcommerce\ORM\Client\AbstractConfig
     */
    public function setTimeout(float $timeout): AbstractConfig
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccept()
    {
        return $this->accept;
    }

    /**
     * @param string $accept
     * @return \Bigcommerce\ORM\Client\AbstractConfig
     */
    public function setAccept(string $accept): AbstractConfig
    {
        /** Only accept json response */
        if ($accept != self::CONTENT_TYPE_JSON) {
            return $this;
        }

        $this->accept = $accept;
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
     * @param string $apiVersion
     * @return \Bigcommerce\ORM\Client\AbstractConfig
     */
    public function setApiVersion(string $apiVersion): AbstractConfig
    {
        /** Only support API V3 */
        if (!in_array($apiVersion, [AbstractConfig::API_VERSION_V3])) {
            return $this;
        }

        $this->apiVersion = $apiVersion;
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
     * @return \Bigcommerce\ORM\Client\AbstractConfig
     */
    public function setDebug(bool $debug): AbstractConfig
    {
        $this->debug = $debug;
        return $this;
    }


}
