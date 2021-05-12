<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductBulkPriceRule;
use Tests\BaseTestCase;

class ProductBulkPriceRuleTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\ProductBulkPriceRule */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new ProductBulkPriceRule();
        $this->entity
            ->setId(1)
            ->setType('type')
            ->setProductId(2)
            ->setAmount(100)
            ->setQuantityMax(200)
            ->setQuantityMin(50);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('type', $this->entity->getType());
        $this->assertEquals(2, $this->entity->getProductId());
        $this->assertEquals(100, $this->entity->getAmount());
        $this->assertEquals(200, $this->entity->getQuantityMax());
        $this->assertEquals(50, $this->entity->getQuantityMin());
    }
}
