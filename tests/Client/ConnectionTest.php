<?php
declare(strict_types=1);

namespace Tests\Client;

use Bigcommerce\ORM\Client\AuthConfig;
use Bigcommerce\ORM\Client\BasicConfig;
use Bigcommerce\ORM\Client\Connection;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Stream\Stream;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Tests\BaseTestCase;

class ConnectionTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Client\Connection */
    protected $connection;

    /** @var  \GuzzleHttp\Client|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $client;

    /** @var \Bigcommerce\ORM\Client\AbstractConfig */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = $this->getClient();
        $this->config = $this->getAuthConfig();
        $this->connection = new Connection($this->config, $this->client);
    }

    /**
     * @covers \Bigcommerce\ORM\Client\Connection::__construct
     * @covers \Bigcommerce\ORM\Client\Connection::setConfig
     * @covers \Bigcommerce\ORM\Client\Connection::setClient
     * @covers \Bigcommerce\ORM\Client\Connection::getConfig
     * @covers \Bigcommerce\ORM\Client\Connection::getClient
     * @covers \Bigcommerce\ORM\Client\Connection::getRequestOptions
     * @covers \Bigcommerce\ORM\Client\Connection::setup
     */
    public function testBasicConfig()
    {
        $this->config = $this->getBasicConfig();
        $this->connection = new Connection($this->config, $this->client);

        $this->connection
            ->setClient($this->client)
            ->setConfig($this->config);

        $this->assertEquals($this->config, $this->connection->getConfig());
        $this->assertEquals($this->client, $this->connection->getClient());
    }

    /**
     * @covers \Bigcommerce\ORM\Client\Connection::__construct
     * @covers \Bigcommerce\ORM\Client\Connection::setConfig
     * @covers \Bigcommerce\ORM\Client\Connection::setClient
     * @covers \Bigcommerce\ORM\Client\Connection::getConfig
     * @covers \Bigcommerce\ORM\Client\Connection::getClient
     * @covers \Bigcommerce\ORM\Client\Connection::getRequestOptions
     * @covers \Bigcommerce\ORM\Client\Connection::setup
     */
    public function testAuthConfig()
    {
        $this->config = $this->getAuthConfig();
        $this->connection = new Connection($this->config, $this->client);

        $this->connection
            ->setClient($this->client)
            ->setConfig($this->config);

        $this->assertIsArray($this->connection->getRequestOptions());

        $this->assertEquals($this->config, $this->connection->getConfig());
        $this->assertEquals($this->client, $this->connection->getClient());
    }

    public function testQuery()
    {
        $response = $this->connection->query('/customers', 'api');
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testUpdate()
    {
        $files = ['photo' => $file = dirname(__DIR__) . '/assets/images/lamp.jpg'];
        $response = $this->connection->update('/customers', 'api', ['id' => 1, 'name' => 'My Name'], $files);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testCreate()
    {
        $files = ['photo' => $file = dirname(__DIR__) . '/assets/images/lamp.jpg'];
        $response = $this->connection->create('/customers', 'api', ['name' => 'My Name'], $files);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testDelete()
    {
        $response = $this->connection->delete('/customers?id:in=1,2,3', 'api');
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    private function getBasicConfig()
    {
        $basicCredentials = [
            'storeUrl' => 'storeUrl',
            'username' => 'username',
            'apiKey' => 'apiKey'
        ];

        return new BasicConfig($basicCredentials);
    }

    private function getAuthConfig()
    {
        $authCredentials = [
            'clientId' => 'clientId',
            'authToken' => 'authToken',
            'storeHash' => 'storeHash',
            'baseUrl' => 'baseUrl',
        ];
        $authConfig = new AuthConfig($authCredentials);
        $authConfig
            ->setTimeout(60)
            ->setAccept('application/json')
            ->setVerify(true)
            ->setDebug(true)
            ->setProxy('tcp://localhost:8080');

        return $authConfig;
    }

    private function getResponse()
    {
        $many = [
            'data' => [
                '0' => ['id' => 1]
            ]
        ];
        $headers = ['api_version' => 'v3'];
        $body = Stream::factory(json_encode($many));

        return new Response(200, $headers, $body);
    }

    private function getClient()
    {
        $client = $this->prophet->prophesize(Client::class);
        $client->get(Argument::any(), Argument::any())->willReturn($this->getResponse());
        $client->put(Argument::any(), Argument::any())->willReturn($this->getResponse());
        $client->post(Argument::any(), Argument::any())->willReturn($this->getResponse());
        $client->delete(Argument::any(), Argument::any())->willReturn($this->getResponse());

        return $client->reveal();
    }
}