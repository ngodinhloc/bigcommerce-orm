<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

interface ClientInterface
{
    /**
     * @param string|null $query
     * @param string|null $resourceType
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function findAll(string $query = null, string $resourceType = null);

    /**
     * @param string|null $query
     * @param string|null $resourceType
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function findBy(string $query = null, string $resourceType = null);

    /**
     * @param string|null $query
     * @param string|null $resourceType
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function find(string $query = null, string $resourceType = null);

    /**
     * @param string|null $resourcePath
     * @param string|null $resourceType
     * @param array|null $data
     * @param array|null $files
     * @param bool $batch
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function create(string $resourcePath = null, string $resourceType = null, array $data = null, array $files = null, bool $batch = false);

    /**
     * @param string|null $resourcePath
     * @param string|null $resourceType
     * @param array|null $data
     * @param array|null $files
     * @param bool $batch
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function update(string $resourcePath = null, string $resourceType = null, array $data = null, array $files = null, bool $batch = false);

    /**
     * @param string|null $resourcePath
     * @param string|null $resourceType
     * @return array|bool|int
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function delete(string $resourcePath = null, string $resourceType = null);
}
