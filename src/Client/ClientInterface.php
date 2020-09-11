<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

interface ClientInterface
{
    /**
     * @param string|null $query
     * @return int|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function count(string $query = null);

    /**
     * @param string|null $query
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function findAll(string $query = null);

    /**
     * @param string|null $query
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function findBy(string $query = null);

    /**
     * @param string|null $query
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function find(string $query = null);

    /**
     * @param string|null $path
     * @param array|null $data
     * @param array|null $files
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function create(string $path = null, array $data = null, array $files = null);

    /**
     * @param string|null $path
     * @param array|null $data
     * @param array|null $files
     * @return array|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function update(string $path = null, array $data = null, array $files = null);
}
