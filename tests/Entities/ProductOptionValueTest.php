<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductOptionValue;
use Tests\BaseTestCase;

class ProductOptionValueTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductOptionValue */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new ProductOptionValue();
        $this->entity
            ->setSortOrder(1)
            ->setId(2)
            ->setProductId(3)
            ->setValueData([])
            ->setLabel('age')
            ->setIsDefault(true)
            ->setOptionId(4);

        $this->assertEquals(1, $this->entity->getSortOrder());
        $this->assertEquals(2, $this->entity->getId());
        $this->assertEquals(3, $this->entity->getProductId());
        $this->assertEquals([], $this->entity->getValueData());
        $this->assertEquals('age', $this->entity->getLabel());
        $this->assertEquals(true, $this->entity->isDefault());
        $this->assertEquals(4, $this->entity->getOptionId());
    }
}