<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductBulkPriceRule;
use Tests\BaseTestCase;

class ProductBulkPriceRuleTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductBulkPriceRule */
    protected $rule;

    public function testSettersAndGetters()
    {
        $this->rule = new ProductBulkPriceRule();
        $this->rule
            ->setId(1)
            ->setType('type')
            ->setProductId(2)
            ->setAmount(100)
            ->setQuantityMax(200)
            ->setQuantityMin(50);

        $this->assertEquals(1, $this->rule->getId());
        $this->assertEquals('type', $this->rule->getType());
        $this->assertEquals(2, $this->rule->getProductId());
        $this->assertEquals(100, $this->rule->getAmount());
        $this->assertEquals(200, $this->rule->getQuantityMax());
        $this->assertEquals(50, $this->rule->getQuantityMin());
    }
}