<?php
declare(strict_types=1);

namespace Tests\Events;

use Bigcommerce\ORM\Entities\Address;
use Bigcommerce\ORM\Entities\Customer;
use Bigcommerce\ORM\Events\EntityManagerEvent;
use Tests\BaseTestCase;

class EntityManagerEventTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Events\EntityManagerEvent */
    protected $event;

    /**
     * @covers \Bigcommerce\ORM\Events\EntityManagerEvent::__construct
     * @covers \Bigcommerce\ORM\Events\EntityManagerEvent::setEntity
     * @covers \Bigcommerce\ORM\Events\EntityManagerEvent::setName
     * @covers \Bigcommerce\ORM\Events\EntityManagerEvent::getEntity
     * @covers \Bigcommerce\ORM\Events\EntityManagerEvent::getName
     */
    public function testSettersAndGetters()
    {
        $name = 'Entity.Created';
        $entity = new Customer();

        $this->event = new EntityManagerEvent($name, $entity);
        $this->assertEquals($name, $this->event->getName());
        $this->assertEquals($entity, $this->event->getEntity());

        $newName = 'Entity.Updated';
        $newEntity = new Address();
        $this->event
            ->setName($newName)
            ->setEntity($newEntity);
        $this->assertEquals($newName, $this->event->getName());
        $this->assertEquals($newEntity, $this->event->getEntity());
    }
}