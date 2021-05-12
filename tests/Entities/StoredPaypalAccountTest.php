<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\StoredPaypalAccount;
use Tests\BaseTestCase;

class StoredPaypalAccountTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\StoredPaypalAccount */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new StoredPaypalAccount();
        $this->entity
            ->setId(1)
            ->setType('visa')
            ->setToken('abc-def');

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('visa', $this->entity->getType());
        $this->assertEquals('abc-def', $this->entity->getToken());
    }
}
