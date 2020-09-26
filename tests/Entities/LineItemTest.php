<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\LineItem;
use Tests\BaseTestCase;

class LineItemTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\LineItem */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new LineItem();
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