<?php
declare(strict_types=1);

namespace Tests;

use Bigcommerce\ORM\Entity;

class EntityTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entity */
    protected $entity;

    /**
     * @covers \Bigcommerce\ORM\Entity::setId
     * @covers \Bigcommerce\ORM\Entity::getId
     * @covers \Bigcommerce\ORM\Entity::getMetadata
     * @covers \Bigcommerce\ORM\Entity::isNew
     * @covers \Bigcommerce\ORM\Entity::isPatched
     */
    public function testSettersAndGetters(){
        $this->entity = new Entity();
        $this->entity->setId(1);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertNull($this->entity->getMetadata());
        $this->assertFalse($this->entity->isPatched());
        $this->assertFalse($this->entity->isNew());
    }
}