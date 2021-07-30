<?php
declare(strict_types=1);

namespace Tests\Relation\Handlers;

use Bigcommerce\ORM\Annotations\HasOne;
use Bigcommerce\ORM\Entities\Product;
use Bigcommerce\ORM\Entities\ProductImage;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\Relation\Handlers\HasOneHandler;
use Tests\BaseTestCase;

class HasOneHandlerTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Relation\Handlers\HasOneHandler */
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
     * @covers \Bigcommerce\ORM\Relation\AbstractHandler::getOneRelationValue
     * @covers \Bigcommerce\ORM\Relation\Handlers\HasOneHandler::handle
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testHandle()
    {
        $entity = new Product();
        $entity->setId(1);
        $property = $this->mapper->getEntityReader()->getProperty($entity, 'primaryImage');
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

        $pathParams = ['category_id' => 2];
        $this->handler = new HasOneHandler($this->entityManager);
        $this->handler->handle($entity, $property, $annotation, $data, $pathParams);
        $primary = $entity->getPrimaryImage();
        $this->assertInstanceOf(ProductImage::class, $primary);
        $this->assertEquals(1, $primary->getId());
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testHandleEarlyReturn()
    {
        $entity = new Product();
        $entity->setId(1);
        $property = $this->mapper->getEntityReader()->getProperty($entity, 'primaryImage');
        $annotation = new HasOne([]);
        $annotation->targetClass = ProductImage::class;
        $annotation->field = 'primary_id';
        $annotation->targetField = 'id';

        $pathParams = null;
        $data = [
            'not_primary_id' => 1
        ];

        $this->handler = new HasOneHandler($this->entityManager);
        $this->handler->handle($entity, $property, $annotation, $data, $pathParams);
        $primary = $entity->getPrimaryImage();
        $this->assertNull($primary);
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
        $pathParams2 = ['id' => 1, 'category_id' => 2];
        $auto = false;
        $manager->find($targetClass, 1, $pathParams, $auto)->willReturn($primary);
        $manager->find($targetClass, 1, $pathParams2, $auto)->willReturn($primary);

        return $manager->reveal();
    }
}
