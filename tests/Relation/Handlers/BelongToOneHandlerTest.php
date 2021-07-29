<?php
declare(strict_types=1);

namespace Tests\Relation\Handlers;

use Bigcommerce\ORM\Annotations\BelongToOne;
use Bigcommerce\ORM\Entities\Category;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Exceptions\HandlerException;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\Relation\Handlers\BelongToOneHandler;
use Tests\BaseTestCase;

class BelongToOneHandlerTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Relation\Handlers\BelongToOneHandler */
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
     * @covers \Bigcommerce\ORM\Relation\Handlers\BelongToOneHandler::handle
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testHandle()
    {
        $entity = new Category();
        $property = $this->mapper->getProperty($entity, 'parent');
        $annotation = new BelongToOne([]);
        $annotation->targetClass = Category::class;
        $annotation->field = 'parent';
        $annotation->targetField = 'id';

        $pathParams = null;
        $data = [
            'parent' => 1
        ];

        $this->handler = new BelongToOneHandler($this->entityManager);
        $this->handler->handle($entity, $property, $annotation, $data, $pathParams);
        $parent = $entity->getParent();
        $this->assertInstanceOf(Category::class, $parent);
        $this->assertEquals(1, $parent->getId());
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testHandleEarlyReturn()
    {
        $entity = new Category();
        $property = $this->mapper->getProperty($entity, 'parent');
        $annotation = new BelongToOne([]);
        $annotation->targetClass = Category::class;
        $annotation->field = 'parent';
        $annotation->targetField = 'id';

        $pathParams = null;
        $data = [
            'notParent' => 'invalidId'
        ];

        $this->handler = new BelongToOneHandler($this->entityManager);
        $this->handler->handle($entity, $property, $annotation, $data, $pathParams);
        $parent = $entity->getParent();
        $this->assertNull($parent);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testHandleException()
    {
        $entity = new Category();
        $property = $this->mapper->getProperty($entity, 'parent');
        $annotation = new BelongToOne([]);
        $annotation->targetClass = Category::class;
        $annotation->field = 'parent';
        $annotation->targetField = 'id';

        $pathParams = null;
        $data = [
            'parent' => ['invalidId']
        ];

        $this->handler = new BelongToOneHandler($this->entityManager);
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

        $targetClass = Category::class;
        $parent = new Category();
        $parent->setId(1);
        $pathParams = null;
        $auto = false;
        $manager->find($targetClass, 1, $pathParams, $auto)->willReturn($parent);

        return $manager->reveal();
    }
}
