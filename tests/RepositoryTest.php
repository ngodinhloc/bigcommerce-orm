<?php
declare(strict_types=1);

namespace Tests;

use Bigcommerce\ORM\Entities\Customer;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\QueryBuilder;
use Bigcommerce\ORM\Repository;

class RepositoryTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Repository */
    protected $repository;

    /** @var \Bigcommerce\ORM\EntityManager|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->entityManager = $this->getEntityManager();
        $this->repository = new Repository($this->entityManager);
        $this->repository->setClassName(Customer::class);
    }

    /**
     * @covers \Bigcommerce\ORM\Repository::__construct
     * @covers \Bigcommerce\ORM\Repository::setEntityManager
     * @covers \Bigcommerce\ORM\Repository::setClassName
     * @covers \Bigcommerce\ORM\Repository::getEntityManager
     * @covers \Bigcommerce\ORM\Repository::getClassName
     */
    public function testSettersAndGetters()
    {
        $this->repository = new Repository($this->entityManager);
        $this->repository
            ->setClassName(Customer::class)
            ->setEntityManager($this->entityManager);

        $this->assertEquals(Customer::class, $this->repository->getClassName());
        $this->assertEquals($this->entityManager, $this->repository->getEntityManager());
    }

    /**
     * @covers \Bigcommerce\ORM\Repository::count
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testCount()
    {
        $count = $this->repository->count();
        $this->assertEquals(2, $count);
    }

    /**
     * @covers \Bigcommerce\ORM\Repository::findAll
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testFindAll(){
        $findAll = $this->repository->findAll();
        $this->assertEquals([], $findAll);
    }

    public function testFindBy(){
        $findBy = $this->repository->findBy(null, $this->getQueryBuilder(), false);
        $this->assertEquals([], $findBy);
    }

    public function testFind(){
        $id = 1;
        $customer = $this->repository->find($id, null, false);
        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals(1, $customer->getId());
    }

    private function getQueryBuilder(){
        $queryBuilder = new QueryBuilder();
        $queryBuilder->whereEqual('id',1);

        return $queryBuilder;
    }
    /**
     * @return object|\Prophecy\Prophecy\ProphecySubjectInterface
     */
    private function getEntityManager()
    {
        $entityManager = $this->prophet->prophesize(EntityManager::class);
        $entityManager->count(Customer::class, null)->willReturn(2);
        $entityManager->getMapper()->willReturn(new Mapper());
        $entityManager->findAll(Customer::class, null, null, false)->willReturn([]);
        $entityManager->findBy(Customer::class, null, $this->getQueryBuilder(), false)->willReturn([]);
        $customer = new Customer();
        $customer->setId(1);
        $entityManager->find(Customer::class, 1, null, false)->willReturn($customer);

        return $entityManager->reveal();
    }
}