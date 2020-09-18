<?php
declare(strict_types=1);

namespace Tests;

use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Exceptions\ManagerFactoryException;
use Bigcommerce\ORM\ManagerFactory;

class ManagerFactoryTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\ManagerFactory */
    protected $factory;

    /** @var array */
    protected $configs;

    protected function setUp(): void
    {
        parent::setUp();
        $firstCredential = [
            'storeUrl' => '***',
            'username' => '***',
            'apiKey' => '***'
        ];

        $secondCredential = [
            'clientId' => '***',
            'authToken' => '***',
            'storeHash' => '***',
            'baseUrl' => '***'
        ];

        $this->configs = [
            'firstStore' => [
                'credentials' => $firstCredential
            ],
            'secondStore' => [
                'credentials' => $secondCredential
            ],
            'thirdStore' => [],
        ];

        $this->factory = new ManagerFactory($this->configs);

    }

    /**
     * @covers \Bigcommerce\ORM\ManagerFactory::__construct
     * @covers \Bigcommerce\ORM\ManagerFactory::getEntityManager
     * @covers \Bigcommerce\ORM\ManagerFactory::getManager
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     * @throws \Bigcommerce\ORM\Exceptions\ManagerFactoryException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testConfigNotFound()
    {
        $this->factory = new ManagerFactory($this->configs);
        $invalidConfig = 'invalidConfigName';
        $this->expectException(ManagerFactoryException::class);
        $this->expectExceptionMessage(ManagerFactoryException::ERROR_CONFIG_NOT_FOUND . $invalidConfig);
        $this->factory->getEntityManager($invalidConfig);
    }

    /**
     * @covers \Bigcommerce\ORM\ManagerFactory::getEntityManager
     * @covers \Bigcommerce\ORM\ManagerFactory::getManager
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     * @throws \Bigcommerce\ORM\Exceptions\ManagerFactoryException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testCredentialsNotFound()
    {
        $missingCredentialConfig = 'thirdStore';
        $this->expectException(ManagerFactoryException::class);
        $this->expectExceptionMessage(ManagerFactoryException::ERROR_CREDENTIALS_NOT_FOUND . $missingCredentialConfig);
        $this->factory->getEntityManager($missingCredentialConfig);
    }

    /**
     * @covers \Bigcommerce\ORM\ManagerFactory::getEntityManager
     * @covers \Bigcommerce\ORM\ManagerFactory::getManager
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     * @throws \Bigcommerce\ORM\Exceptions\ManagerFactoryException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testGetEntityManager()
    {
        $firstStore = 'firstStore';
        $firstManager = $this->factory->getEntityManager($firstStore);
        $this->assertInstanceOf(EntityManager::class, $firstManager);

        $firstManagerFromPool = $this->factory->getEntityManager($firstStore);
        $this->assertInstanceOf(EntityManager::class, $firstManagerFromPool);
    }
}