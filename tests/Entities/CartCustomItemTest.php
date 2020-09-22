<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CartCustomItem;
use Tests\BaseTestCase;

class CartCustomItemTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CartCustomItem */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new CartCustomItem();
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