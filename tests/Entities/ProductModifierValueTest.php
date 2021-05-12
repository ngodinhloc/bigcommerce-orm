<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductModifierValue;
use Tests\BaseTestCase;

class ProductModifierValueTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\ProductModifierValue */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new ProductModifierValue();
        $this->entity
            ->setId(1)
            ->setSortOrder(2)
            ->setProductId(111)
            ->setAdjusters([])
            ->setIsDefault(true)
            ->setLabel('S')
            ->setModifierId(10)
            ->setValueData([]);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getSortOrder());
        $this->assertEquals(111, $this->entity->getProductId());
        $this->assertEquals([], $this->entity->getAdjusters());
        $this->assertEquals(true, $this->entity->isDefault());
        $this->assertEquals('S', $this->entity->getLabel());
        $this->assertEquals(10, $this->entity->getModifierId());
        $this->assertEquals([], $this->entity->getValueData());

    }
}
