<?php
declare(strict_types=1);

namespace Tests\Relation\Handlers;

use Bigcommerce\ORM\Annotations\HasMany;
use Bigcommerce\ORM\Entities\Product;
use Bigcommerce\ORM\Entities\ProductReview;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\QueryBuilder;
use Bigcommerce\ORM\Relation\Handlers\BelongToManyHandler;
use Bigcommerce\ORM\Relation\Handlers\HasManyHandler;
use Tests\BaseTestCase;

class HasManyHandlerTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Relation\Handlers\HasManyHandler */
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
     * @covers \Bigcommerce\ORM\Relation\Handlers\HasManyHandler::__construct
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
        $auto = false;
        $manager->findBy($targetClass, $pathParams, $queryBuilder, $auto)->willReturn([]);

        return $manager->reveal();
    }
}