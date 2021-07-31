<?php

namespace Tests\Mapper;

use Bigcommerce\ORM\Entities\ProductVideo;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Mapper\Autoloader;
use Tests\EntityManagerTest;

class AutoloaderTest extends EntityManagerTest
{
    /** @var \Bigcommerce\ORM\Mapper\Autoloader */
    private $autoloader;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = $this->getClient();
        $this->mapper = $this->getMapper();
        $this->dispatcher = $this->getDispatcher();
        $this->entityManager = new EntityManager($this->client, $this->mapper, $this->dispatcher);
        $this->autoloader = new Autoloader($this->entityManager);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testAutoload()
    {
        $entity = new ProductVideo();
        $this->entityManager->patch($entity);
        $newEntity = $this->autoloader->autoLoad($entity);
        $this->assertSame($entity, $newEntity);
    }
}
