<?php
declare(strict_types=1);

namespace Tests\Relation\Handlers;

use Bigcommerce\ORM\Annotations\BelongToMany;
use Bigcommerce\ORM\Entities\Category;
use Bigcommerce\ORM\Entities\Product;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Exceptions\HandlerException;
use Bigcommerce\ORM\Mapper\EntityMapper;
use Bigcommerce\ORM\QueryBuilder;
use Bigcommerce\ORM\Relation\Handlers\BelongToManyHandler;
use Tests\BaseTestCase;

class BelongToManyHandlerTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Relation\Handlers\BelongToManyHandler */
    protected $handler;

    /** @var \Bigcommerce\ORM\Mapper\EntityMapper */
    protected $mapper;

    /** @var \Bigcommerce\ORM\EntityManager|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mapper = new EntityMapper();
        $this->entityManager = $this->getEntityManager();
    }

    /**
     * @covers \Bigcommerce\ORM\Relation\AbstractHandler::__construct
     * @covers \Bigcommerce\ORM\Relation\AbstractHandler::setEntityManager
     * @covers \Bigcommerce\ORM\Relation\AbstractHandler::getEntityManager
     * @covers \Bigcommerce\ORM\Relation\AbstractHandler::getManyRelationValue
     * @covers \Bigcommerce\ORM\Relation\Handlers\BelongToManyHandler::handle
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\HandlerException
     */
    public function testHandle()
    {
        $entity = new Product();
        $property = $this->mapper->getEntityReader()->getProperty($entity, 'categories');
        $annotation = new BelongToMany([]);
        $annotation->targetClass = Category::class;
        $annotation->field = 'categories';
        $annotation->targetField = 'id';

        $pathParams = null;
        $data = [
            'categories' => [1, 2, 3]
        ];

        $this->handler = new BelongToManyHandler();
        $this->handler->setEntityManager($this->entityManager);
        $this->assertEquals($this->entityManager, $this->handler->getEntityManager());

        $this->handler->handle($entity, $property, $annotation, $data, $pathParams);
        $categories = $entity->getCategories();
        $this->assertEquals([], $categories);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\HandlerException
     */
    public function testHandleThrowException()
    {
        $entity = new Product();
        $property = $this->mapper->getEntityReader()->getProperty($entity, 'categories');
        $annotation = new BelongToMany([]);
        $annotation->targetClass = Category::class;
        $annotation->field = 'categories';
        $annotation->targetField = 'id';

        $pathParams = null;
        $data = [
            'categories' => [1, 2, ['invalidId']]
        ];

        $this->handler = new BelongToManyHandler();
        $this->handler->setEntityManager($this->entityManager);
        $this->expectException(HandlerException::class);
        $this->handler->handle($entity, $property, $annotation, $data, $pathParams);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\HandlerException
     */
    public function testHandleException()
    {
        $entity = new Product();
        $property = $this->mapper->getEntityReader()->getProperty($entity, 'categories');
        $annotation = new BelongToMany([]);
        $annotation->targetClass = Category::class;
        $annotation->field = 'categories';
        $annotation->targetField = 'id';

        $pathParams = null;
        $data = [
            'categories' => [['invalidIds']]
        ];

        $this->handler = new BelongToManyHandler();
        $this->handler->setEntityManager($this->entityManager);
        $this->expectException(HandlerException::class);
        $this->handler->handle($entity, $property, $annotation, $data, $pathParams);
    }

    /**
     * @return object|\Prophecy\Prophecy\ProphecySubjectInterface
     */
    private function getEntityManager()
    {
        $manager = $this->prophet->prophesize(EntityManager::class);
        $manager->getMapper()->willReturn($this->mapper);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->whereIn('id', [1, 2, 3]);
        $targetClass = Category::class;
        $pathParams = null;
        $auto = false;
        $manager->findBy($targetClass, $pathParams, $queryBuilder, $auto)->willReturn([]);

        return $manager->reveal();
    }
}
