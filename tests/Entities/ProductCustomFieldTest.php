<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductCustomField;
use Tests\BaseTestCase;

class ProductCustomFieldTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductCustomField */
    protected $field;

    public function testSettersAndGetters()
    {
        $this->field = new ProductCustomField();
        $this->field
            ->setId(1)
            ->setProductId(2)
            ->setName('age')
            ->setValue(30);

        $this->assertEquals(1, $this->field->getId());
        $this->assertEquals(2, $this->field->getProductId());
        $this->assertEquals('age', $this->field->getName());
        $this->assertEquals(30, $this->field->getValue());
    }
}