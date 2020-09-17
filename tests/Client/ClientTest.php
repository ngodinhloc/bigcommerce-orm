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
    /** @var \Bigcommerce\ORM\Client\Client */
    protected $client;

    /** @var \Bigcommerce\ORM\Client\Connection|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $connection;

    /** @var \Bigcommerce\ORM\Cache\FileCache\FileCachePool|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $cache;

    /** @var \Monolog\Logger|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $logger;

    protected function setUp(): void
    {
        parent::setUp();
        $this->connection = $this->getConnection();
        $this->logger = $this->getLogger();
        $this->cache = $this->getCache();
        $this->client = new Client($this->connection, $this->cache, $this->logger);
    }

    /**
     * @covers \Bigcommerce\ORM\Client\Client::__construct
     * @covers \Bigcommerce\ORM\Client\Client::setConnection
     * @covers \Bigcommerce\ORM\Client\Client::setLogger
     * @covers \Bigcommerce\ORM\Client\Client::setCachePool
     * @covers \Bigcommerce\ORM\Client\Client::getConnection
     * @covers \Bigcommerce\ORM\Client\Client::getLogger
     * @covers \Bigcommerce\ORM\Client\Client::getCachePool
     */
    public function testSettersAndGetters()
    {
        $this->client = new Client($this->connection, $this->cache, $this->logger);
        $this->client
            ->setLogger($this->logger)
            ->setCachePool($this->cache)
            ->setConnection($this->connection);

        $this->assertEquals($this->logger, $this->client->getLogger());
        $this->assertEquals($this->cache, $this->client->getCachePool());
        $this->assertEquals($this->connection, $this->client->getConnection());
    }

    public function testCount()
    {
        $count = $this->client->count('/customers');
        $this->assertEquals(1, $count);
    }

    public function testQueryThrowException()
    {
        $this->expectException(ClientException::class);
        $this->client->count(null);
    }

    public function testFindAll()
    {
        $findAll = $this->client->findAll('/customers');
        $this->assertEquals(1, count($findAll));
    }

    public function testFindBy()
    {
        $findBy = $this->client->findBy('/customers?id:in=1,2,3');
        $this->assertEquals(1, count($findBy));
    }

    public function testFind()
    {
        $find = $this->client->find('/customers/1');
        $this->assertIsArray($find);
    }

    public function testFindThrowGuzzleException()
    {
        $this->expectException(ClientException::class);
        $this->client->find('/customers/2');
    }

    public function testFindThrowException()
    {
        $this->expectException(ClientException::class);
        $this->client->find('/customers/3');
    }

    public function testCreate()
    {
        $data = ['id' => 1];
        $create = $this->client->create('/customers', $data, []);
        $this->assertIsArray($create);
    }

    public function testBatchCreate()
    {
        $data = ['id' => 1];
        $create = $this->client->create('/customers', $data, [], true);
        $this->assertIsArray($create);
    }

    public function testCreateThrowGuzzleException()
    {
        $data = ['id' => 1];
        $this->expectException(ClientException::class);
        $this->client->create('/customers/2', $data, []);
    }

    public function testCreateThrowException()
    {
        $data = ['id' => 1];
        $this->expectException(ClientException::class);
        $this->client->create('/customers/3', $data, []);
    }

    public function testUpdate()
    {
        $data = ['id' => 1];
        $update = $this->client->update('/customers/1', $data, []);
        $this->assertIsArray($update);
    }

    public function testBatchUpdate()
    {
        $data = ['id' => 1];
        $update = $this->client->update('/customers/1', $data, [], true);
        $this->assertIsArray($update);
    }

    public function testUpdateThrowGuzzleException()
    {
        $data = ['id' => 1];
        $this->expectException(ClientException::class);
        $this->client->update('/customers/2', $data, []);
    }

    public function testUpdateThrowException()
    {
        $data = ['id' => 1];
        $this->expectException(ClientException::class);
        $this->client->update('/customers/3', $data, []);
    }

    public function testDelete()
    {
        $result = $this->client->delete('/customers?id:in=1,2');
        $this->assertTrue($result);
    }

    public function testDeleteThrowGuzzleException()
    {
        $this->expectException(ClientException::class);
        $this->client->delete('/customers?id:in=0,1');
    }

    public function testDeleteThrowException()
    {
        $this->expectException(ClientException::class);
        $this->client->delete('/customers?id:in=0,2');
    }

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
        $connection->query('/customers')->willReturn($response);
        $connection->query('/customers?id:in=1,2,3')->willReturn($response);
        $connection->query('/customers')->willReturn($response);
        $connection->query('/customers/1')->willReturn($response);
        $connection->create('/customers', ['id' => 1], [])->willReturn($response);
        $connection->update('/customers/1', ['id' => 1], [])->willReturn($response);
        $guzzleException = new \GuzzleHttp\Exception\ClientException('Guzzle Client Exception', $request, $response);
        $exception = new \Exception('Exception error');

        $connection->query('/customers/2')->willThrow($guzzleException);
        $connection->query('/customers/3')->willThrow($exception);
        $connection->create('/customers/2', ['id' => 1], [])->willThrow($guzzleException);
        $connection->create('/customers/3', ['id' => 1], [])->willThrow($exception);
        $connection->update('/customers/2', ['id' => 1], [])->willThrow($guzzleException);
        $connection->update('/customers/3', ['id' => 1], [])->willThrow($exception);
        $connection->delete('/customers?id:in=1,2')->willReturn($response);
        $connection->delete('/customers?id:in=0,1')->willThrow($guzzleException);
        $connection->delete('/customers?id:in=0,2')->willThrow($exception);

        return $connection->reveal();
    }

    private function getCache()
    {
        $cache = $this->prophet->prophesize(FileCachePool::class);
        $cacheItem = new FileCacheItem();
        $cacheItem->setIsHit(false);
        $cache->getItem(Argument::any())->willReturn($cacheItem);
        $cache->save(Argument::any())->willReturn(true);
        return $cache->reveal();
    }

    private function getLogger()
    {
        $logger = $this->prophet->prophesize(Logger::class);

        return $logger->reveal();
    }
}