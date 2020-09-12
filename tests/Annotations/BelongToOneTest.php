<?php
declare(strict_types=1);

namespace Tests\Annotations;

use Bigcommerce\ORM\Annotations\BelongToOne;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Relation\Handlers\BelongToOneHandler;
use Tests\BaseTestCase;

class BelongToOneTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Annotations\BelongToOne */
    protected $annotation;

    /**
     * @covers \Bigcommerce\ORM\Annotations\BelongToOne::getHandler
     */
    public function testGetHandler(){
        $this->annotation = new BelongToOne([]);
        $entityManager = $this->prophet->prophesize(EntityManager::class)->reveal();
        /** @var BelongToOneHandler $handler */
        $handler = $this->annotation->getHandler($entityManager);
        $this->assertInstanceOf(BelongToOneHandler::class, $handler);
        $this->assertEquals($entityManager, $handler->getEntityManager());
    }
}