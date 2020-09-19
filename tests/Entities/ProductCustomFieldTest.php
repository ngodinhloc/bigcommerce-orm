<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductCustomField;
use Tests\BaseTestCase;

class ProductCustomFieldTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductCustomField */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new ProductCustomField();
        $this->entity
            ->setId(1)
            ->setProductId(2)
            ->setName('age')
            ->setValue(30);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getProductId());
        $this->assertEquals('age', $this->entity->getName());
        $this->assertEquals(30, $this->entity->getValue());
    }
}