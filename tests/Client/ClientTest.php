<?php

declare(strict_types=1);

namespace Tests\Client;

use Bigcommerce\ORM\Cache\FileCache\FileCacheItem;
use Bigcommerce\ORM\Cache\FileCache\FileCachePool;
use Bigcommerce\ORM\Client\AuthConfig;
use Bigcommerce\ORM\Client\BasicConfig;
use Bigcommerce\ORM\Client\Client;
use Bigcommerce\ORM\Client\RequestOption;
use Bigcommerce\ORM\Config\AuthCredential;
use Bigcommerce\ORM\Config\BasicCredential;
use Bigcommerce\ORM\Config\ConfigOption;
use Bigcommerce\ORM\Exceptions\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Stream\Stream;
use Monolog\Logger;
use Prophecy\Argument;
use Tests\BaseTestCase;

class ClientTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Client\Client */
    protected $client;

    /** @var \Bigcommerce\ORM\Client\AbstractConfig */
    protected $config;

    /** @var \Bigcommerce\ORM\Client\RequestOption */
    protected $requestOption;

    /** @var \GuzzleHttp\Client|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $guzzleClient;

    /** @var \Monolog\Logger|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $logger;

    /** @var \Bigcommerce\ORM\Cache\FileCache\FileCachePool|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $cache;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = $this->getAuthConfig();
        $this->requestOption = new RequestOption($this->config);
        $this->logger = $this->getLogger();
        $this->cache = $this->getCache();
        $this->guzzleClient = $this->getGuzzleClient();
        $this->client = new Client($this->config, $this->guzzleClient, $this->logger, $this->cache);
    }

    public function testSettersAndGetters()
    {
        $this->client = new Client($this->config, $this->guzzleClient, $this->logger, $this->cache);
        $this->client
            ->setConfig($this->config)
            ->setGuzzleClient($this->guzzleClient)
            ->setLogger($this->logger)
            ->setCachePool($this->cache);

        $this->assertEquals($this->cache, $this->client->getCachePool());
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testFindAll()
    {
        $findAll = $this->client->findAll('/customers', 'api');
        $this->assertEquals(1, count($findAll));
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testFindBy()
    {
        $findBy = $this->client->findBy('/customers?id:in=1,2,3', 'api');
        $this->assertEquals(1, count($findBy));
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testFind()
    {
        $find = $this->client->find('/customers/1', 'api');
        $this->assertIsArray($find);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testFindThrowGuzzleException()
    {
        $this->expectException(ClientException::class);
        $this->client->find('/customers/2', 'api');
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testFindThrowException()
    {
        $this->expectException(ClientException::class);
        $this->client->find('/customers/3', 'api');
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function testCreate()
    {
        $data = ['id' => 1];
        $create = $this->client->create('/customers', 'api', $data, []);
        $this->assertIsArray($create);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function testBatchCreate()
    {
        $data = ['id' => 1];
        $create = $this->client->create('/customers', 'api', $data, [], true);
        $this->assertIsArray($create);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function testCreateThrowGuzzleException()
    {
        $data = ['id' => 1];
        $this->expectException(ClientException::class);
        $this->client->create('/customers/2', 'api', $data, []);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function testCreateThrowException()
    {
        $data = ['id' => 1];
        $this->expectException(ClientException::class);
        $this->client->create('/customers/3', 'api', $data, []);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function testUpdate()
    {
        $data = ['id' => 1];
        $update = $this->client->update('/customers/1', 'api', $data, []);
        $this->assertIsArray($update);

        $result = $update = $this->client->update('/customers/1', 'api', [], []);
        $this->assertTrue($result);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function testUpdateNull()
    {
        $this->expectException(ClientException::class);
        $result = $update = $this->client->update(null, 'api', [], []);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function testBatchUpdate()
    {
        $data = ['id' => 1];
        $update = $this->client->update('/customers/1', 'api', $data, [], true);
        $this->assertIsArray($update);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function testUpdateThrowGuzzleException()
    {
        $data = ['id' => 1];
        $this->expectException(ClientException::class);
        $this->client->update('/customers/2', 'api', $data, []);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function testUpdateThrowException()
    {
        $data = ['id' => 1];
        $this->expectException(ClientException::class);
        $this->client->update('/customers/3', 'api', $data, []);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function testDelete()
    {
        $result = $this->client->delete('/customers?id:in=1,2', 'api');
        $this->assertTrue($result);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function testDeleteThrowGuzzleException()
    {
        $this->expectException(ClientException::class);
        $this->client->delete('/customers?id:in=0,1', 'api');
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     */
    public function testDeleteThrowException()
    {
        $this->expectException(ClientException::class);
        $this->client->delete('/customers?id:in=0,2', 'api');
    }

    /**
     *
     */
    public function testSetPaymentAccessToken()
    {
        $this->client->setPaymentAccessToken('123');
        $this->assertInstanceOf(Client::class, $this->client);
    }

    /**
     * @return object|\Prophecy\Prophecy\ProphecySubjectInterface
     */
    private function getGuzzleClient()
    {
        $many = [
            'data' => [
                '0' => ['id' => 1]
            ]
        ];
        $headers = ['api_version' => 'v3'];
        $body = Stream::factory(json_encode($many));
        $response = new Response(200, $headers, $body);
        $request = new Request('GET', 'http://www.someurl.com');

        $client = $this->prophet->prophesize(\GuzzleHttp\Client::class);
        $client->get($this->config->getApiUrl() . '/customers', $this->getRequestOptionArray())->willReturn($response);
        $client->get($this->config->getApiUrl() . '/customers?id:in=1,2,3', $this->getRequestOptionArray())->willReturn($response);
        $client->get($this->config->getApiUrl() . '/customers', $this->getRequestOptionArray())->willReturn($response);
        $client->get($this->config->getApiUrl() . '/customers/1', $this->getRequestOptionArray())->willReturn($response);
        $client->post($this->config->getApiUrl() . '/customers', $this->getRequestOptionArray(['id' => 1]))->willReturn($response);
        $client->put($this->config->getApiUrl() . '/customers/1', $this->getRequestOptionArray(['id' => 1]))->willReturn($response);
        $guzzleException = new \GuzzleHttp\Exception\ClientException('Guzzle Client Exception', $request, $response);
        $exception = new \Exception('Exception error');

        $client->get($this->config->getApiUrl() . '/customers/2', $this->getRequestOptionArray())->willThrow($guzzleException);
        $client->get($this->config->getApiUrl() . '/customers/3', $this->getRequestOptionArray())->willThrow($exception);
        $client->post($this->config->getApiUrl() . '/customers/2', $this->getRequestOptionArray(['id' => 1]))->willThrow($guzzleException);
        $client->post($this->config->getApiUrl() . '/customers/3', $this->getRequestOptionArray(['id' => 1]))->willThrow($exception);
        $client->put($this->config->getApiUrl() . '/customers/2', $this->getRequestOptionArray(['id' => 1]))->willThrow($guzzleException);
        $client->put($this->config->getApiUrl() . '/customers/3', $this->getRequestOptionArray(['id' => 1]))->willThrow($exception);
        $client->delete($this->config->getApiUrl() . '/customers?id:in=1,2', $this->getRequestOptionArray())->willReturn($response);
        $client->delete($this->config->getApiUrl() . '/customers?id:in=0,1', $this->getRequestOptionArray())->willThrow($guzzleException);
        $client->delete($this->config->getApiUrl() . '/customers?id:in=0,2', $this->getRequestOptionArray())->willThrow($exception);

//        $connection->setPaymentAccessToken('123')->willReturn(true);

        return $client->reveal();
    }

    /**
     * @return object|\Prophecy\Prophecy\ProphecySubjectInterface
     */
    private function getCache()
    {
        $cache = $this->prophet->prophesize(FileCachePool::class);
        $cacheItem = new FileCacheItem();
        $cacheItem->setIsHit(false);
        $cache->getItem(Argument::any())->willReturn($cacheItem);
        $cache->save(Argument::any())->willReturn(true);

        return $cache->reveal();
    }

    /**
     * @return \Bigcommerce\ORM\Client\AuthConfig
     * @throws \Bigcommerce\ORM\Exceptions\ConfigException
     */
    private function getAuthConfig()
    {
        $authCredentials = [
            'clientId' => 'clientId',
            'authToken' => 'authToken',
            'storeHash' => 'storeHash',
            'baseUrl' => 'baseUrl',
        ];
        $credential = new AuthCredential($authCredentials);
        $configOption = new ConfigOption();
        $configOption
            ->setTimeout(60)
            ->setAccept('application/json')
            ->setVerify(true)
            ->setDebug(true)
            ->setProxy('tcp://localhost:8080');

        return new AuthConfig($credential, $configOption);
    }

    /**
     * @return \Bigcommerce\ORM\Client\BasicConfig
     * @throws \Bigcommerce\ORM\Exceptions\ConfigException
     */
    private function getBasicConfig()
    {
        $basicCredentials = [
            'storeUrl' => 'storeUrl',
            'username' => 'username',
            'apiKey' => 'apiKey'
        ];
        $credential = new BasicCredential($basicCredentials);
        $configOption = new ConfigOption();
        $configOption
            ->setTimeout(60)
            ->setAccept('application/json')
            ->setVerify(true)
            ->setDebug(true)
            ->setProxy('tcp://localhost:8080');

        return new BasicConfig($credential, $configOption);
    }

    /**
     * @return object|\Prophecy\Prophecy\ProphecySubjectInterface
     */
    private function getLogger()
    {
        $logger = $this->prophet->prophesize(Logger::class);

        return $logger->reveal();
    }

    private function getRequestOptionArray(array $data = null, array $files = null)
    {
        $requestOption = new RequestOption($this->config);
        if (!empty($data)) {
            $requestOption->addRequestBody($data);
        }
        if (!empty($files)) {
            $requestOption->addRequestFiles($files);
        }

        return $requestOption->toArray();
    }
}
