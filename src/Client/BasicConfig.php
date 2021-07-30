<?php

declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

use Bigcommerce\ORM\Config\BasicCredential;
use Bigcommerce\ORM\Config\ConfigOption;

class BasicConfig extends AbstractConfig
{
    /** @var \Bigcommerce\ORM\Config\BasicCredential */
    protected $credential;

    /**
     * BasicConfig constructor.
     * @param \Bigcommerce\ORM\Config\BasicCredential $credential
     * @param \Bigcommerce\ORM\Config\ConfigOption $configOption
     */
    public function __construct(BasicCredential $credential, ConfigOption $configOption)
    {
        $this->credential = $credential;
        $this->configOption = $configOption;
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return rtrim($this->credential->getStoreUrl(), '/') . $this->getPathPrefix();
    }

    /**
     * @return string
     */
    public function getPaymentUrl()
    {
        return rtrim($this->credential->getStoreUrl(), '/') . $this->getPathPrefix() . '/payments';
    }

    /**
     * @return array|string[]
     */
    public function getAuth()
    {
        return [$this->credential->getUsername(), $this->credential->getApiKey()];
    }

    /**
     * @return array|null
     */
    public function getAuthHeaders()
    {
        return null;
    }

    /**
     * @return \Bigcommerce\ORM\Config\BasicCredential
     */
    public function getCredential(): BasicCredential
    {
        return $this->credential;
    }

    /**
     * @param \Bigcommerce\ORM\Config\BasicCredential $credential
     * @return \Bigcommerce\ORM\Client\BasicConfig
     */
    public function setCredential(BasicCredential $credential): BasicConfig
    {
        $this->credential = $credential;

        return $this;
    }
}
