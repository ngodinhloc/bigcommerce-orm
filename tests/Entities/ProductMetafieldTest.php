<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductMetafield;
use Tests\BaseTestCase;

class ProductMetafieldTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductMetafield */
    protected $field;

    public function testSettersAndGetters()
    {
        $this->field = new ProductMetafield();
        $this->field
            ->setValue('value')
            ->setProductId(2)
            ->setId(3)
            ->setDateModified('2020-09-17')
            ->setDateCreated('2020-09-16')
            ->setResourceType('file')
            ->setResourceId(4)
            ->setPermissionSet('read')
            ->setNamespace('namespace')
            ->setKey('age')
            ->setDescription('desc');

        $this->assertEquals('value', $this->field->getValue());
        $this->assertEquals(2, $this->field->getProductId());
        $this->assertEquals(3, $this->field->getId());
        $this->assertEquals('2020-09-17', $this->field->getDateModified());
        $this->assertEquals('2020-09-16', $this->field->getDateCreated());
        $this->assertEquals('file', $this->field->getResourceType());
        $this->assertEquals(4, $this->field->getResourceId());
        $this->assertEquals('read', $this->field->getPermissionSet());
        $this->assertEquals('namespace', $this->field->getNamespace());
        $this->assertEquals('age', $this->field->getKey());
        $this->assertEquals('desc', $this->field->getDescription());
    }
}