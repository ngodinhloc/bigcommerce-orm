<?php
declare(strict_types=1);

namespace Tests\Relation\Handlers;

use Bigcommerce\ORM\Annotations\BelongToMany;
use Bigcommerce\ORM\Annotations\BelongToOne;
use Bigcommerce\ORM\Annotations\HasOne;
use Bigcommerce\ORM\Entities\Category;
use Bigcommerce\ORM\Entities\Customer;
use Bigcommerce\ORM\Entities\Product;
use Bigcommerce\ORM\Entities\ProductImage;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\QueryBuilder;
use Bigcommerce\ORM\Relation\Handlers\BelongToManyHandler;
use Bigcommerce\ORM\Relation\Handlers\BelongToOneHandler;
use Bigcommerce\ORM\Relation\Handlers\HasOneHandler;
use Tests\BaseTestCase;

class HasOneHandlerTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Relation\Handlers\HasOneHandler */
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
     * @covers \Bigcommerce\ORM\Relation\Handlers\HasOneHandler::__construct
     * @covers \Bigcommerce\ORM\Relation\Handlers\HasOneHandler::handle
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testHandle()
    {
        $entity = new Product();
        $entity->setId(1);
        $property = $this->mapper->getProperty($entity, 'primaryImage');
        $annotation = new HasOne([]);
        $annotation->targetClass = ProductImage::class;
        $annotation->field = 'primary_id';
        $annotation->targetField = 'id';

        $pathParams = null;
        $data = [
            'primary_id' => 1
        ];

        $this->handler = new HasOneHandler($this->entityManager);
        $this->handler->handle($entity, $property, $annotation, $data, $pathParams);
        $primary = $entity->getPrimaryImage();
        $this->assertInstanceOf(ProductImage::class, $primary);
        $this->assertEquals(1, $primary->getId());
    }

    /**
     * @return object|\Prophecy\Prophecy\ProphecySubjectInterface
     */
    private function getEntityManager()
    {
        $manager = $this->prophet->prophesize(EntityManager::class);
        $manager->getMapper()->willReturn($this->mapper);

        $targetClass = ProductImage::class;
        $primary = new ProductImage();
        $primary->setId(1);
        $pathParams = ['id' => 1];
        $auto = false;
        $manager->find($targetClass, 1, $pathParams, $auto)->willReturn($primary);

        return $manager->reveal();
    }
}