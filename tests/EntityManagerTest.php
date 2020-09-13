<?php
declare(strict_types=1);

namespace Tests;

use Bigcommerce\ORM\Client\Client;
use Bigcommerce\ORM\Entities\Customer;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\QueryBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EntityManagerTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Client\Client|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $client;

    /** @var \Bigcommerce\ORM\Mapper|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $mapper;

    /** @var \Symfony\Component\EventDispatcher\EventDispatcher|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $dispatcher;

    /** @var \Bigcommerce\ORM\EntityManager */
    protected $entityManager;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->client = $this->getClient();
        $this->mapper = $this->getMapper();
        $this->dispatcher = $this->getDispatcher();
        $this->entityManager = new EntityManager($this->client, $this->mapper, $this->dispatcher);
    }

    /**
     * @covers \Bigcommerce\ORM\EntityManager::setClient
     * @covers \Bigcommerce\ORM\EntityManager::setMapper
     * @covers \Bigcommerce\ORM\EntityManager::setEventDispatcher
     * @covers \Bigcommerce\ORM\EntityManager::getClient
     * @covers \Bigcommerce\ORM\EntityManager::getMapper
     * @covers \Bigcommerce\ORM\EntityManager::getEventDispatcher
     */
    public function testSettersAndGetters()
    {
        $this->entityManager
            ->setClient($this->client)
            ->setMapper($this->mapper)
            ->setEventDispatcher($this->dispatcher);

        $this->assertEquals($this->client, $this->entityManager->getClient());
        $this->assertEquals($this->mapper, $this->entityManager->getMapper());
        $this->assertEquals($this->dispatcher, $this->entityManager->getEventDispatcher());
    }

    /**
     * @covers \Bigcommerce\ORM\EntityManager::count
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testCount()
    {
        $class = Customer::class;
        $expect = 2;
        $count = $this->entityManager->count($class, []);

        $this->assertEquals($expect, $count);
    }

    /**
     * @covers \Bigcommerce\ORM\EntityManager::findAll
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testFindAll()
    {
        $class = Customer::class;
        $pathParams = [];
        $order = ['date_created' => 'asc'];
        $expectedResult = [];
        $findAll = $this->entityManager->findAll($class, $pathParams, $order, false);

        $this->assertEquals($expectedResult, $findAll);
    }

    /**
     * @covers \Bigcommerce\ORM\EntityManager::findBy
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testFindBy()
    {
        $class = Customer::class;
        $pathParams = null;
        $queryBuilder = new QueryBuilder();
        $queryBuilder->whereIn('id', [1, 2, 3]);
        $expectedResult = [];
        $findBy = $this->entityManager->findBy($class, $pathParams, $queryBuilder, false);

        $this->assertEquals($expectedResult, $findBy);
    }

    /**
     * @covers \Bigcommerce\ORM\EntityManager::find
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testFind()
    {
        $class = Customer::class;
        $pathParams = null;
        $expectedId = 1;
        $customer = $this->entityManager->find($class, $expectedId, $pathParams, false);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals($expectedId, $customer->getId());
    }

    /**
     * @return object|\Prophecy\Prophecy\ProphecySubjectInterface
     */
    private function getClient()
    {
        $countPath = '/customers';
        $countReturn = 2;

        $findAllPath = '/customers?sort=date_created:asc&include=addresses';
        $findAllResult = [];

        $findByPath = '/customers?id:in=1,2,3&include=addresses';
        $findByResult = [];

        $findPath = '/customers/1?include=addresses';
        $findResult = ['id' => 1];

        $client = $this->prophet->prophesize(Client::class);
        $client->count($countPath)->willReturn($countReturn);
        $client->findAll($findAllPath)->willReturn($findAllResult);
        $client->findBy($findByPath)->willReturn($findByResult);
        $client->find($findPath)->willReturn($findResult);

        return $client->reveal();
    }

    /**
     * @return \Bigcommerce\ORM\Mapper
     */
    private function getMapper()
    {
        return new Mapper();
    }

    /**
     * @return object|\Prophecy\Prophecy\ProphecySubjectInterface
     */
    private function getDispatcher()
    {
        $dispatcher = $this->prophet->prophesize(EventDispatcher::class);

        return $dispatcher->reveal();
    }
}