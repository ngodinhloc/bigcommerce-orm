<?php
declare(strict_types=1);

namespace Tests\Client;

use Bigcommerce\ORM\Client\AuthConfig;
use Bigcommerce\ORM\Client\BasicConfig;
use Bigcommerce\ORM\Client\Connection;
use Bigcommerce\ORM\Client\RequestOption;
use Bigcommerce\ORM\Config\AuthCredential;
use Bigcommerce\ORM\Config\BasicCredential;
use Bigcommerce\ORM\Config\ConfigOption;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Stream\Stream;
use Monolog\Logger;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Tests\BaseTestCase;

class ConnectionTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Client\Connection */
    protected $connection;

    /** @var  \GuzzleHttp\Client|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $client;

    /** @var \Bigcommerce\ORM\Client\AbstractConfig */
    protected $config;

    /** @var \Monolog\Logger|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $logger;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = $this->getClient();
        $this->config = $this->getAuthConfig();
        $this->logger = $this->getLogger();
        $this->connection = new Connection($this->config, $this->logger, $this->client);
    }

    public function testBasicConfig()
    {
        $this->config = $this->getBasicConfig();
        $this->connection = new Connection($this->config, $this->logger, $this->client);

        $this->connection
            ->setClient($this->client)
            ->setConfig($this->config)
            ->setLogger($this->logger);

        $this->assertInstanceOf(RequestOption::class, $this->connection->getOption());
        $this->assertEquals($this->config, $this->connection->getConfig());
        $this->assertEquals($this->client, $this->connection->getClient());
        $this->assertEquals($this->logger, $this->connection->getLogger());
    }

    public function testAuthConfig()
    {
        $this->config = $this->getAuthConfig();
        $this->connection = new Connection($this->config, $this->logger, $this->client);

        $this->connection
            ->setClient($this->client)
            ->setConfig($this->config)
            ->setLogger($this->logger);

        $this->assertInstanceOf(RequestOption::class, $this->connection->getOption());
        $this->assertEquals($this->config, $this->connection->getConfig());
        $this->assertEquals($this->client, $this->connection->getClient());
        $this->assertEquals($this->logger, $this->connection->getLogger());
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testQuery()
    {
        $response = $this->connection->query('/customers', 'api');
        $this->assertInstanceOf(ResponseInterface::class, $response);

        $response = $this->connection->query('/payments', 'payment');
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testUpdate()
    {
        $files = ['photo' => $file = dirname(__DIR__) . '/assets/images/lamp.jpg'];
        $response = $this->connection->update('/customers', 'api', ['id' => 1, 'name' => 'My Name'], $files);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCreate()
    {
        $files = ['photo' => $file = dirname(__DIR__) . '/assets/images/lamp.jpg'];
        $response = $this->connection->create('/customers', 'api', ['name' => 'My Name'], $files);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDelete()
    {
        $response = $this->connection->delete('/customers?id:in=1,2,3', 'api');
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * testSetPaymentAccessToken
     */
    public function testSetPaymentAccessToken()
    {
        $this->connection->setPaymentAccessToken('123');
        $requestOption = $this->connection->getOption();
        $header = $requestOption->getHeaders();
        $this->assertArrayHasKey('Authorization', $header);
        $token = $header['Authorization'];
        $this->assertEquals("PAT 123", $token);
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
     * @return \GuzzleHttp\Psr7\Response
     */
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

    /**
     * @return object|\Prophecy\Prophecy\ProphecySubjectInterface
     */
    private function getClient()
    {
        $client = $this->prophet->prophesize(Client::class);
        $client->get(Argument::any(), Argument::any())->willReturn($this->getResponse());
        $client->put(Argument::any(), Argument::any())->willReturn($this->getResponse());
        $client->post(Argument::any(), Argument::any())->willReturn($this->getResponse());
        $client->delete(Argument::any(), Argument::any())->willReturn($this->getResponse());

        return $client->reveal();
    }

    /**
     * @return object|\Prophecy\Prophecy\ProphecySubjectInterface
     */
    private function getLogger()
    {
        $logger = $this->prophet->prophesize(Logger::class);

        return $logger->reveal();
    }
}
