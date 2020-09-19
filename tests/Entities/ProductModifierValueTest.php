<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductModifierValue;
use Tests\BaseTestCase;

class ProductModifierValueTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductModifierValue */
    protected $value;

    public function testSettersAndGetters()
    {
        $this->value = new ProductModifierValue();
        $this->value
            ->setId(1)
            ->setSortOrder(2)
            ->setProductId(111)
            ->setAdjusters([])
            ->setIsDefault(true)
            ->setLabel('S')
            ->setModifierId(10)
            ->setValueData([]);

        $this->assertEquals(1, $this->value->getId());
        $this->assertEquals(2, $this->value->getSortOrder());
        $this->assertEquals(111, $this->value->getProductId());
        $this->assertEquals([], $this->value->getAdjusters());
        $this->assertEquals(true, $this->value->isDefault());
        $this->assertEquals('S', $this->value->getLabel());
        $this->assertEquals(10, $this->value->getModifierId());
        $this->assertEquals([], $this->value->getValueData());

    }
}