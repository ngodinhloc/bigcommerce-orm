<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\StoredCard;
use Tests\BaseTestCase;

class StoredCardTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\StoredCard */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new StoredCard();
        $this->entity
            ->setId(1)
            ->setType('visa')
            ->setToken('abc-def');

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('visa', $this->entity->getType());
        $this->assertEquals('abc-def', $this->entity->getToken());
    }
}