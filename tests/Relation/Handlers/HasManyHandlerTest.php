<?php
declare(strict_types=1);

namespace Tests\Relation\Handlers;

use Bigcommerce\ORM\Annotations\HasMany;
use Bigcommerce\ORM\Entities\Product;
use Bigcommerce\ORM\Entities\ProductReview;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\QueryBuilder;
use Bigcommerce\ORM\Relation\Handlers\Exceptions\HandlerException;
use Bigcommerce\ORM\Relation\Handlers\HasManyHandler;
use Tests\BaseTestCase;

class HasManyHandlerTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Relation\Handlers\HasManyHandler */
    protected $handler;

    /** @var \Bigcommerce\ORM\Mapper */
    protected $mapper;

    /** @var \Bigcommerce\ORM\EntityManager|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mapper = new Mapper();
        $this->entityManager = $this->getEntityManager();
    }

    /**
     * @covers \Bigcommerce\ORM\Relation\AbstractHandler::__construct
     * @covers \Bigcommerce\ORM\Relation\AbstractHandler::getManyRelationValue
     * @covers \Bigcommerce\ORM\Relation\Handlers\HasManyHandler::handle
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Relation\Handlers\Exceptions\HandlerException
     */
    public function testHandle()
    {
        $entity = new Product();
        $entity->setId(1);
        $property = $this->mapper->getProperty($entity, 'reviews');
        $annotation = new HasMany([]);
        $annotation->targetClass = ProductReview::class;
        $annotation->field = 'reviews';
        $annotation->targetField = 'id';

        $pathParams = null;
        $data = [
            'reviews' => [1, 2, 3]
        ];

        $this->handler = new HasManyHandler($this->entityManager);
        $this->handler->handle($entity, $property, $annotation, $data, $pathParams);
        $reviews = $entity->getReviews();
        $this->assertEquals([], $reviews);

        $pathParams = ['category_id' => 2];
        $this->handler = new HasManyHandler($this->entityManager);
        $this->handler->handle($entity, $property, $annotation, $data, $pathParams);
        $reviews = $entity->getReviews();
        $this->assertEquals([], $reviews);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Relation\Handlers\Exceptions\HandlerException
     */
    public function testHandleEarlyReturn()
    {
        $entity = new Product();
        $entity->setId(1);
        $property = $this->mapper->getProperty($entity, 'reviews');
        $annotation = new HasMany([]);
        $annotation->targetClass = ProductReview::class;
        $annotation->field = 'reviews';
        $annotation->targetField = 'id';

        $pathParams = ['category_id' => 2];
        $data = [
            'notReviews' => [1, 2, 3]
        ];

        $this->handler = new HasManyHandler($this->entityManager);
        $this->handler->handle($entity, $property, $annotation, $data, $pathParams);
        $reviews = $entity->getReviews();
        $this->assertNull($reviews);
    }

    /**
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Relation\Handlers\Exceptions\HandlerException
     */
    public function testHandleThrowException()
    {
        $entity = new Product();
        $entity->setId(1);
        $property = $this->mapper->getProperty($entity, 'reviews');
        $annotation = new HasMany([]);
        $annotation->targetClass = ProductReview::class;
        $annotation->field = 'reviews';
        $annotation->targetField = 'id';

        $pathParams = ['category_id' => 2];
        $data = [
            'reviews' => new \stdClass()
        ];

        $this->handler = new HasManyHandler($this->entityManager);
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
        $targetClass = ProductReview::class;
        $pathParams = ['id' => 1];
        $pathParams2 = ['id' => 1, 'category_id' => 2];
        $auto = false;
        $manager->findBy($targetClass, $pathParams, $queryBuilder, $auto)->willReturn([]);
        $manager->findBy($targetClass, $pathParams2, $queryBuilder, $auto)->willReturn([]);

        return $manager->reveal();
    }
}
