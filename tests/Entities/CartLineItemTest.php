<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CartLineItem;
use Tests\BaseTestCase;

class CartLineItemTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CartLineItem */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new CartLineItem();
        $this->entity
            ->setId(1)
            ->setQuantity(2)
            ->setListPrice(100)
            ->setProductId(111)
            ->setOptionSelections([]);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getQuantity());
        $this->assertEquals(100, $this->entity->getListPrice());
        $this->assertEquals(111, $this->entity->getProductId());
        $this->assertEquals([], $this->entity->getOptionSelections());
    }
}