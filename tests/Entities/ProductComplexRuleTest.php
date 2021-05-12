<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductComplexRule;
use Tests\BaseTestCase;

class ProductComplexRuleTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\ProductComplexRule */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new ProductComplexRule();
        $this->entity
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

        $this->assertEquals(1, $this->entity->getProductId());
        $this->assertEquals(2, $this->entity->getId());
        $this->assertEquals('url', $this->entity->getImageUrl());
        $this->assertEquals(3, $this->entity->getSortOrder());
        $this->assertEquals([], $this->entity->getConditions());
        $this->assertEquals(true, $this->entity->isEnabled());
        $this->assertEquals([], $this->entity->getPriceAdjuster());
        $this->assertEquals(true, $this->entity->isPurchasingDisabled());
        $this->assertEquals('message', $this->entity->getPurchasingDisabledMessage());
        $this->assertEquals(false, $this->entity->isPurchasingHidden());
        $this->assertEquals(true, $this->entity->isStop());
        $this->assertEquals([], $this->entity->getWeightAdjuster());
    }
}
