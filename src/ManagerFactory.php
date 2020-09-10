<?php
declare(strict_types=1);

namespace Bigcommerce\ORM;

use Bigcommerce\ORM\Exceptions\ManagerFactoryException;

class ManagerFactory
{
    /** @var array */
    protected $configs;

    /** @var \Bigcommerce\ORM\EntityManager[] */
    protected $managerPool;

    /**
     * ManagerFactory constructor.
     * @param array|null $configs
     */
    public function __construct(array $configs = null)
    {
        $this->configs = $configs;
    }

    /**
     * @param string $name
     * @return \Bigcommerce\ORM\EntityManager
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     * @throws \Bigcommerce\ORM\Exceptions\ManagerFactoryException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function getEntityManager(string $name)
    {
        if (!isset($this->configs[$name])) {
            throw new ManagerFactoryException(ManagerFactoryException::MGS_CONFIG_NOT_FOUND . $name);
        }

        if (isset($this->managerPool[$name])) {
            return $this->managerPool[$name];
        }

        return $this->getManager($name, $this->configs[$name]);
    }

    /**
     * @param string $name
     * @param array $config
     * @return \Bigcommerce\ORM\EntityManager
     * @throws \Bigcommerce\ORM\Client\Exceptions\ConfigException
     * @throws \Bigcommerce\ORM\Exceptions\ManagerFactoryException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    private function getManager(string $name, array $config)
    {
        if (!isset($config['credentials'])) {
            throw new ManagerFactoryException(ManagerFactoryException::MGS_CREDENTIALS_NOT_FOUND . $name);
        }

        $credentials = $config['credentials'];
        $options = isset($config['options']) ? $config['options'] : null;
        $cache = isset($config['cache']) ? $config['cache'] : null;
        $dispatcher = isset($config['dispatcher']) ? $config['dispatcher'] : null;
        $logger = isset($config['logger']) ? $config['logger'] : null;

        $configuration = new Configuration($credentials, $options, $cache, $dispatcher, $logger);
        $entityManager = $configuration->configEntityManager();
        $this->managerPool[$name] = $entityManager;

        return $entityManager;
    }
}