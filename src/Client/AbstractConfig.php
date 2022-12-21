<?php

declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

use Bigcommerce\ORM\Config\ConfigOption;

/**
 * Class AbstractConfig
 * @package Bigcommerce\ORM\Client
 */
abstract class AbstractConfig
{
    const API_STORE_PREFIX_V3 = '/stores/%s/v3';
    const API_PATH_PREFIX_V3 = '/api/v3';
    const PAYMENT_STORE_PREFIX = '/stores/%s';
    const RESOURCE_TYPE_API = 'api';
    const RESOURCE_TYPE_PAYMENT = 'payment';
    protected \Bigcommerce\ORM\Config\ConfigOption $configOption;

    /**
     * @return string
     */
    abstract public function getApiUrl();

    /**
     * @return string
     */
    abstract public function getPaymentUrl();

    /**
     * @return array|null
     */
    abstract public function getAuthHeaders();

    /**
     * @return array|null
     */
    abstract public function getAuth();

    /**
     * @return string
     */
    public function getPathPrefix()
    {
        switch ($this->getConfigOption()->getApiVersion()) {
            case ConfigOption::API_VERSION_V3:
            default:
                return self::API_PATH_PREFIX_V3;
        }
    }

    /**
     * @return string
     */
    public function getApiStorePrefix()
    {
        switch ($this->getConfigOption()->getApiVersion()) {
            case ConfigOption::API_VERSION_V3:
            default:
                return self::API_STORE_PREFIX_V3;
        }
    }

    /**
     * @return string
     */
    public function getPaymentStorePrefix()
    {
        switch ($this->getConfigOption()->getApiVersion()) {
            case ConfigOption::API_VERSION_V3:
            default:
                return self::PAYMENT_STORE_PREFIX;
        }
    }

    /**
     * @return \Bigcommerce\ORM\Config\ConfigOption
     */
    public function getConfigOption(): ConfigOption
    {
        return $this->configOption;
    }

    /**
     * @param \Bigcommerce\ORM\Config\ConfigOption $configOption
     * @return \Bigcommerce\ORM\Client\AbstractConfig
     */
    public function setConfigOption(ConfigOption $configOption): AbstractConfig
    {
        $this->configOption = $configOption;

        return $this;
    }
}
