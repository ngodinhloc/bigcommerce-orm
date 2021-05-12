<?php
declare(strict_types=1);

namespace Tests\Annotations;

use Bigcommerce\ORM\Annotations\BelongToMany;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Relation\Handlers\BelongToManyHandler;
use Tests\BaseTestCase;

class BelongToManyTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Annotations\BelongToMany */
    protected $annotation;

    /**
     * @covers \Bigcommerce\ORM\Annotations\BelongToMany::getHandler
     */
    public function testGetHandler()
    {
        $this->annotation = new BelongToMany([]);
        $entityManager = $this->prophet->prophesize(EntityManager::class)->reveal();
        /** @var BelongToManyHandler $handler */
        $handler = $this->annotation->getHandler($entityManager);
        $this->assertInstanceOf(BelongToManyHandler::class, $handler);
        $this->assertEquals($entityManager, $handler->getEntityManager());
    }
}
