<?php
declare(strict_types=1);

namespace Tests\Relation\Handlers;

use Bigcommerce\ORM\Annotations\BelongToMany;
use Bigcommerce\ORM\Annotations\BelongToOne;
use Bigcommerce\ORM\Entities\Category;
use Bigcommerce\ORM\Entities\Customer;
use Bigcommerce\ORM\Entities\Product;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\QueryBuilder;
use Bigcommerce\ORM\Relation\Handlers\BelongToManyHandler;
use Bigcommerce\ORM\Relation\Handlers\BelongToOneHandler;
use Tests\BaseTestCase;

class BelongToOneHandlerTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Relation\Handlers\BelongToOneHandler */
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
     * @covers \Bigcommerce\ORM\Relation\Handlers\BelongToOneHandler::__construct
     * @covers \Bigcommerce\ORM\Relation\Handlers\BelongToOneHandler::handle
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
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