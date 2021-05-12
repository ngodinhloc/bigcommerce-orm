<?php
declare(strict_types=1);

namespace Tests\Client;

use Bigcommerce\ORM\Cache\FileCache\FileCacheItem;
use Bigcommerce\ORM\Cache\FileCache\FileCachePool;
use Bigcommerce\ORM\Client\Client;
use Bigcommerce\ORM\Client\Connection;
use Bigcommerce\ORM\Client\Exceptions\ClientException;
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

    /** @var \Bigcommerce\ORM\Client\Connection|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $connection;

    /** @var \Bigcommerce\ORM\Cache\FileCache\FileCachePool|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $cache;

    protected function setUp(): void
    {
        parent::setUp();
        $this->connection = $this->getConnection();
        $this->cache = $this->getCache();
        $this->client = new Client($this->connection, $this->cache);
    }

    /**
     * @covers \Bigcommerce\ORM\Client\Client::__construct
     * @covers \Bigcommerce\ORM\Client\Client::setConnection
     * @covers \Bigcommerce\ORM\Client\Client::setCachePool
     * @covers \Bigcommerce\ORM\Client\Client::getConnection
     * @covers \Bigcommerce\ORM\Client\Client::getCachePool
     */
    public function testSettersAndGetters()
    {
        $this->client = new Client($this->connection, $this->cache);
        $this->client
            ->setCachePool($this->cache)
            ->setConnection($this->connection);

        $this->assertEquals($this->cache, $this->client->getCachePool());
        $this->assertEquals($this->connection, $this->client->getConnection());
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testFindAll()
    {
        $findAll = $this->client->findAll('/customers', 'api');
        $this->assertEquals(1, count($findAll));
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testFindBy()
    {
        $findBy = $this->client->findBy('/customers?id:in=1,2,3', 'api');
        $this->assertEquals(1, count($findBy));
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testFind()
    {
        $find = $this->client->find('/customers/1', 'api');
        $this->assertIsArray($find);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testFindThrowGuzzleException()
    {
        $this->expectException(ClientException::class);
        $this->client->find('/customers/2', 'api');
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testFindThrowException()
    {
        $this->expectException(ClientException::class);
        $this->client->find('/customers/3', 'api');
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testCreate()
    {
        $data = ['id' => 1];
        $create = $this->client->create('/customers', 'api', $data, []);
        $this->assertIsArray($create);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testBatchCreate()
    {
        $data = ['id' => 1];
        $create = $this->client->create('/customers', 'api', $data, [], true);
        $this->assertIsArray($create);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testCreateThrowGuzzleException()
    {
        $data = ['id' => 1];
        $this->expectException(ClientException::class);
        $this->client->create('/customers/2', 'api', $data, []);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testCreateThrowException()
    {
        $data = ['id' => 1];
        $this->expectException(ClientException::class);
        $this->client->create('/customers/3', 'api', $data, []);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
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
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testUpdateNull()
    {
        $this->expectException(ClientException::class);
        $result = $update = $this->client->update(null, 'api', [], []);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testBatchUpdate()
    {
        $data = ['id' => 1];
        $update = $this->client->update('/customers/1', 'api', $data, [], true);
        $this->assertIsArray($update);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testUpdateThrowGuzzleException()
    {
        $data = ['id' => 1];
        $this->expectException(ClientException::class);
        $this->client->update('/customers/2', 'api', $data, []);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testUpdateThrowException()
    {
        $data = ['id' => 1];
        $this->expectException(ClientException::class);
        $this->client->update('/customers/3', 'api', $data, []);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testDelete()
    {
        $result = $this->client->delete('/customers?id:in=1,2', 'api');
        $this->assertTrue($result);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testDeleteThrowGuzzleException()
    {
        $this->expectException(ClientException::class);
        $this->client->delete('/customers?id:in=0,1', 'api');
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
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
    private function getConnection()
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

        $connection = $this->prophet->prophesize(Connection::class);
        $connection->query('/customers', 'api')->willReturn($response);
        $connection->query('/customers?id:in=1,2,3', 'api')->willReturn($response);
        $connection->query('/customers', 'api')->willReturn($response);
        $connection->query('/customers/1', 'api')->willReturn($response);
        $connection->create('/customers', 'api', ['id' => 1], [])->willReturn($response);
        $connection->update('/customers/1', 'api', ['id' => 1], [])->willReturn($response);
        $guzzleException = new \GuzzleHttp\Exception\ClientException('Guzzle Client Exception', $request, $response);
        $exception = new \Exception('Exception error');

        $connection->query('/customers/2', 'api')->willThrow($guzzleException);
        $connection->query('/customers/3', 'api')->willThrow($exception);
        $connection->create('/customers/2', 'api', ['id' => 1], [])->willThrow($guzzleException);
        $connection->create('/customers/3', 'api', ['id' => 1], [])->willThrow($exception);
        $connection->update('/customers/2', 'api', ['id' => 1], [])->willThrow($guzzleException);
        $connection->update('/customers/3', 'api', ['id' => 1], [])->willThrow($exception);
        $connection->delete('/customers?id:in=1,2', 'api')->willReturn($response);
        $connection->delete('/customers?id:in=0,1', 'api')->willThrow($guzzleException);
        $connection->delete('/customers?id:in=0,2', 'api')->willThrow($exception);
        $connection->setPaymentAccessToken('123')->willReturn(true);

        return $connection->reveal();
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
}
