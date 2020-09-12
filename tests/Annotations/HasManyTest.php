<?php
declare(strict_types=1);

namespace Tests\Annotations;

use Bigcommerce\ORM\Annotations\HasMany;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Relation\Handlers\HasManyHandler;
use Tests\BaseTestCase;

class HasManyTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Annotations\HasMany */
    protected $annotation;

    /**
     * @covers \Bigcommerce\ORM\Annotations\HasMany::getHandler
     */
    public function testGetHandler(){
        $this->annotation = new HasMany([]);
        $entityManager = $this->prophet->prophesize(EntityManager::class)->reveal();
        /** @var \Bigcommerce\ORM\Relation\Handlers\HasManyHandler $handler */
        $handler = $this->annotation->getHandler($entityManager);
        $this->assertInstanceOf(HasManyHandler::class, $handler);
        $this->assertEquals($entityManager, $handler->getEntityManager());
    }
}