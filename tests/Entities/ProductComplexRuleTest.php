<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductComplexRule;
use Tests\BaseTestCase;

class ProductComplexRuleTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductComplexRule */
    protected $rule;

    public function testSettersAndGetters()
    {
        $this->rule = new ProductComplexRule();
        $this->rule
            ->setProductId(1)
            ->setId(2)
            ->setImageUrl('url')
            ->setSortOrder(3)
            ->setConditions([])
            ->setEnabled(true)
            ->setPriceAdjuster([])
            ->setPurchasingDisabled(true)
            ->setPurchasingDisabledMessage('message')
            ->setPurchasingHidden(false)
            ->setStop(true)
            ->setWeightAdjuster([]);

        $this->assertEquals(1, $this->rule->getProductId());
        $this->assertEquals(2, $this->rule->getId());
        $this->assertEquals('url', $this->rule->getImageUrl());
        $this->assertEquals(3, $this->rule->getSortOrder());
        $this->assertEquals([], $this->rule->getConditions());
        $this->assertEquals(true, $this->rule->isEnabled());
        $this->assertEquals([], $this->rule->getPriceAdjuster());
        $this->assertEquals(true, $this->rule->isPurchasingDisabled());
        $this->assertEquals('message', $this->rule->getPurchasingDisabledMessage());
        $this->assertEquals(false, $this->rule->isPurchasingHidden());
        $this->assertEquals(true, $this->rule->isStop());
        $this->assertEquals([], $this->rule->getWeightAdjuster());
    }
}