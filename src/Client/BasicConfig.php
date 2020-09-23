<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

use Bigcommerce\ORM\Client\Exceptions\ConfigException;

class BasicConfig extends AbstractConfig
{
    /** @var string */
    protected $storeUrl;

    /** @var string */
    protected $username;

    /** @var string */
    protected $apiKey;

    const REQUIRED_CONFIGURATION_DATA = ['storeUrl', 'username', 'apiKey'];

    /**
     * BasicConfig constructor.
     *
     * @param array|null $config config
     * [
     *  'storeUrl' =>
     *  'username' =>
     *  'apiKey' =>
     * ]
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     */
    public function __construct(?array $config = null)
    {
        if (!isset($config['storeUrl']) || !isset($config['username']) || !isset($config['apiKey'])) {
            throw new ConfigException(ConfigException::ERROR_MISSING_CONFIG . implode(",", self::REQUIRED_CONFIGURATION_DATA));
        }
        $this->storeUrl = $config['storeUrl'];
        $this->username = $config['username'];
        $this->apiKey = $config['apiKey'];
    }

    /**
     * @return string
     */
    public function getStoreUrl()
    {
        return $this->storeUrl;
    }

    /**
     * @param string|null $storeUrl
     * @return \Bigcommerce\ORM\Client\BasicConfig
     */
    public function setStoreUrl(?string $storeUrl)
    {
        $this->storeUrl = $storeUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return \Bigcommerce\ORM\Client\BasicConfig
     */
    public function setUsername(?string $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string|null $apiKey
     * @return \Bigcommerce\ORM\Client\BasicConfig
     */
    public function setApiKey(?string $apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return rtrim($this->getStoreUrl(), '/') . $this->getPathPrefix();
    }

    /**
     * @return string
     */
    public function getPaymentUrl()
    {
        return rtrim($this->getStoreUrl(), '/') . $this->getPathPrefix() . '/payments';
    }

}
