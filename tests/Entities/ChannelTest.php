<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Channel;
use Tests\BaseTestCase;

class ChannelTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\Channel */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new Channel();
        $this->entity
            ->setName('name')
            ->setId(1)
            ->setDateCreated('2020-09-16')
            ->setDateModified('2020-09-17')
            ->setType('web')
            ->setExternalId('012')
            ->setIsEnabled(true)
            ->setPlatform('BC');

        $this->assertEquals('name', $this->entity->getName());
        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('2020-09-16', $this->entity->getDateCreated());
        $this->assertEquals('2020-09-17', $this->entity->getDateModified());
        $this->assertEquals('web', $this->entity->getType());
        $this->assertEquals('012', $this->entity->getExternalId());
        $this->assertEquals(true, $this->entity->isEnabled());
        $this->assertEquals('BC', $this->entity->getPlatform());
    }
}
