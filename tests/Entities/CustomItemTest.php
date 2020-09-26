<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CustomItem;
use Tests\BaseTestCase;

class CustomItemTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CustomItem */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new CustomItem();
        $this->entity
            ->setName('name')
            ->setId(1)
            ->setListPrice(100)
            ->setSku('sku')
            ->setQuantity(2);

        $this->assertEquals('name', $this->entity->getName());
        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(100, $this->entity->getListPrice());
        $this->assertEquals('sku', $this->entity->getSku());
        $this->assertEquals(2, $this->entity->getQuantity());
    }

}