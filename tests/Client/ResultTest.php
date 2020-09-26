<?php
declare(strict_types=1);

namespace Tests\Client;

use Bigcommerce\ORM\Client\Exceptions\ResultException;
use Bigcommerce\ORM\Client\Result;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Stream\Stream;
use Tests\BaseTestCase;

class ResultTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Client\Result */
    protected $result;

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testNullResponse()
    {
        $this->result = new Result();
        $this->expectException(ResultException::class);
        $this->result->get(Result::RETURN_TYPE_ALL);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testReturnFalse()
    {
        $many = [
            'data' => [
                '0' => ['id' => 1]
            ]
        ];
        $headers = ['api_version' => 'v3'];
        $body = Stream::factory(json_encode($many));
        $response = new Response(300, $headers, $body);
        $this->result = new Result();
        $this->result->setResponse($response);
        $get = $this->result->get(Result::RETURN_TYPE_ALL);
        $this->assertFalse($get);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testGetAll()
    {
        $many = [
            'data' => [
                '0' => ['id' => 1]
            ]
        ];
        $headers = ['api_version' => 'v3'];
        $body = Stream::factory(json_encode($many));
        $response = new Response(200, $headers, $body);
        $this->result = new Result();
        $this->result->setResponse($response);
        $this->assertEquals($response, $this->result->getResponse());

        $all = $this->result->get(Result::RETURN_TYPE_ALL);
        $this->assertIsArray($all);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testGetBool()
    {
        $many = [
            'data' => [
                '0' => ['id' => 1]
            ]
        ];
        $headers = ['api_version' => 'v3'];
        $body = Stream::factory(json_encode($many));
        $response = new Response(200, $headers, $body);
        $this->result = new Result($response);
        $bool = $this->result->get(Result::RETURN_TYPE_BOOL);
        $this->assertTrue($bool);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testGetDelete()
    {
        $many = [
            'data' => [
                '0' => ['id' => 1]
            ]
        ];
        $headers = ['api_version' => 'v3'];
        $body = Stream::factory(json_encode($many));
        $response = new Response(204, $headers, $body);
        $this->result = new Result($response);
        $bool = $this->result->get(Result::RETURN_TYPE_BOOL);
        $this->assertTrue($bool);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testGetFirst()
    {
        $many = [
            'data' => [
                '0' => ['id' => 1]
            ]
        ];
        $headers = ['api_version' => 'v3'];
        $body = Stream::factory(json_encode($many));
        $response = new Response(200, $headers, $body);
        $this->result = new Result($response);
        $first = $this->result->get(Result::RETURN_TYPE_FIRST);
        $this->assertIsArray($first);
        $this->assertArrayHasKey('id', $first);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testGetCount()
    {
        $many = [
            'data' => [
                '0' => ['id' => 1]
            ]
        ];
        $headers = ['api_version' => 'v3'];
        $body = Stream::factory(json_encode($many));
        $response = new Response(200, $headers, $body);
        $this->result = new Result($response);
        $count = $this->result->get(Result::RETURN_TYPE_COUNT);
        $this->assertEquals(1, $count);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function testGetOne()
    {
        $many = [
            'data' => [
                'id' => 1
            ]
        ];
        $headers = ['api_version' => 'v3'];
        $body = Stream::factory(json_encode($many));
        $response = new Response(200, $headers, $body);
        $this->result = new Result($response);
        $one = $this->result->get(Result::RETURN_TYPE_ONE);
        $this->assertIsArray($one);
        $this->assertArrayHasKey('id', $one);
        $this->assertEquals(1, $one['id']);
    }
}