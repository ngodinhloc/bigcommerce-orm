<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductMetafield;
use Tests\BaseTestCase;

class ProductMetafieldTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductMetafield */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new ProductMetafield();
        $this->entity
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

        $this->assertEquals('value', $this->entity->getValue());
        $this->assertEquals(2, $this->entity->getProductId());
        $this->assertEquals(3, $this->entity->getId());
        $this->assertEquals('2020-09-17', $this->entity->getDateModified());
        $this->assertEquals('2020-09-16', $this->entity->getDateCreated());
        $this->assertEquals('file', $this->entity->getResourceType());
        $this->assertEquals(4, $this->entity->getResourceId());
        $this->assertEquals('read', $this->entity->getPermissionSet());
        $this->assertEquals('namespace', $this->entity->getNamespace());
        $this->assertEquals('age', $this->entity->getKey());
        $this->assertEquals('desc', $this->entity->getDescription());
    }
}