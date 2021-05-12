<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductOption;
use Tests\BaseTestCase;

class ProductOptionTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\ProductOption */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new ProductOption();
        $this->entity
            ->setId(1)
            ->setProductId(2)
            ->setType('type')
            ->setName('name')
            ->setValue('value')
            ->setSortOrder(3)
            ->setOptionValues([])
            ->setDisplayName('display name');

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getProductId());
        $this->assertEquals('type', $this->entity->getType());
        $this->assertEquals('name', $this->entity->getName());
        $this->assertEquals('value', $this->entity->getValue());
        $this->assertEquals(3, $this->entity->getSortOrder());
        $this->assertEquals([], $this->entity->getOptionValues());
        $this->assertEquals('display name', $this->entity->getDisplayName());
    }
}
