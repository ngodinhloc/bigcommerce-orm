<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

interface ClientInterface
{
    /**
     * @param string|null $query
     * @param string|null $resourceType
     * @return array|bool
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function findAll(?string $query, ?string $resourceType);

    /**
     * @param string|null $query
     * @param string|null $resourceType
     * @return array|bool
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function findBy(?string $query, ?string $resourceType);

    /**
     * @param string|null $query
     * @param string|null $resourceType
     * @return array|bool
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function find(?string $query, ?string $resourceType);

    /**
     * @param string|null $resourcePath
     * @param string|null $resourceType
     * @param array|null $data
     * @param array|null $files
     * @param bool $batch
     * @return array|bool
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function create(?string $resourcePath, ?string $resourceType, ?array $data, ?array $files, bool $batch = false);

    /**
     * @param string|null $resourcePath
     * @param string|null $resourceType
     * @param array|null $data
     * @param array|null $files
     * @param bool $batch
     * @return array|bool
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function update(?string $resourcePath, ?string $resourceType, ?array $data, ?array $files, bool $batch = false);

    /**
     * @param string|null $resourcePath
     * @param string|null $resourceType
     * @return array|bool|int
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function delete(?string $resourcePath, ?string $resourceType);
}
