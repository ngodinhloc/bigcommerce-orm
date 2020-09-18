<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CustomerAttribute;
use Tests\BaseTestCase;

class CustomerAttributeTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CustomerAttribute */
    protected $attribute;

    public function testSettersAndGetters()
    {
        $this->attribute = new CustomerAttribute();
        $this->attribute
            ->setName('name')
            ->setType('file')
            ->setId(1)
            ->setDateModified('2020-09-16')
            ->setDateCreated('2020-09-15');

        $this->assertEquals('name', $this->attribute->getName());
        $this->assertEquals('file', $this->attribute->getType());
        $this->assertEquals(1, $this->attribute->getId());
        $this->assertEquals('2020-09-16', $this->attribute->getDateModified());
        $this->assertEquals('2020-09-15', $this->attribute->getDateCreated());
    }
}