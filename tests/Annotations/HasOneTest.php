<?php
declare(strict_types=1);

namespace Tests\Annotations;

use Bigcommerce\ORM\Annotations\HasOne;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Relation\Handlers\HasOneHandler;
use Tests\BaseTestCase;

class HasOneTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Annotations\HasOne */
    protected $annotation;

    /**
     * @covers \Bigcommerce\ORM\Annotations\HasOne::getHandler
     */
    public function testGetHandler()
    {
        $this->annotation = new HasOne([]);
        $entityManager = $this->prophet->prophesize(EntityManager::class)->reveal();
        /** @var \Bigcommerce\ORM\Relation\Handlers\HasOneHandler $handler */
        $handler = $this->annotation->getHandler($entityManager);
        $this->assertInstanceOf(HasOneHandler::class, $handler);
        $this->assertEquals($entityManager, $handler->getEntityManager());
    }
}