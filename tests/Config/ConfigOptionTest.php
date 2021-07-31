<?php

namespace Tests\Config;

use Bigcommerce\ORM\Config\ConfigOption;
use PHPUnit\Framework\TestCase;

class ConfigOptionTest extends TestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Config\ConfigOption */
    private $configOption;

    public function testSettersAndGetters()
    {
        $options = [
            'accept' => 'application/json',
            'timeout' => 600,
            'verify' => true,
            'debug' => false,
            'proxy' => 'proxy',
            'apiVersion' => 'v3'
        ];
        $this->configOption = new ConfigOption($options);

        $this->assertEquals($options['accept'], $this->configOption->getAccept());
        $this->assertEquals($options['timeout'], $this->configOption->getTimeout());
        $this->assertEquals($options['verify'], $this->configOption->isVerify());
        $this->assertEquals($options['debug'], $this->configOption->isDebug());
        $this->assertEquals($options['proxy'], $this->configOption->getProxy());
        $this->assertEquals($options['apiVersion'], $this->configOption->getApiVersion());

        $this->configOption
            ->setAccept(ConfigOption::CONTENT_TYPE_BCV1)
            ->setAccept('invalidValue')
            ->setTimeout(100)
            ->setVerify(false)
            ->setDebug(true)
            ->setApiVersion('v3')
            ->setApiVersion('invalidValue')
            ->setProxy('proxy');

        $this->assertEquals(ConfigOption::CONTENT_TYPE_BCV1, $this->configOption->getAccept());
        $this->assertEquals(100, $this->configOption->getTimeout());
        $this->assertEquals(false, $this->configOption->isVerify());
        $this->assertEquals(true, $this->configOption->isDebug());
        $this->assertEquals('proxy', $this->configOption->getProxy());
        $this->assertEquals('v3', $this->configOption->getApiVersion());
    }
}
