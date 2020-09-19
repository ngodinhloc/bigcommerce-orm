<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductVariantMetafield;
use Tests\BaseTestCase;

class ProductVariantMetafieldTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductVariantMetafield */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new ProductVariantMetafield();
        $this->entity
            ->setProductId(1)
            ->setId(2)
            ->setValue('value')
            ->setDateModified('2020-09-17')
            ->setDateCreated('2020-09-16')
            ->setDescription('desc')
            ->setKey('key')
            ->setNamespace('ns')
            ->setPermissionSet('read')
            ->setResourceId(3)
            ->setResourceType('file')
            ->setVariantId(4);

        $this->assertEquals(1, $this->entity->getProductId());
        $this->assertEquals(2, $this->entity->getId());
        $this->assertEquals('value', $this->entity->getValue());
        $this->assertEquals('2020-09-17', $this->entity->getDateModified());
        $this->assertEquals('2020-09-16', $this->entity->getDateCreated());
        $this->assertEquals('desc', $this->entity->getDescription());
        $this->assertEquals('key', $this->entity->getKey());
        $this->assertEquals('ns', $this->entity->getNamespace());
        $this->assertEquals('read', $this->entity->getPermissionSet());
        $this->assertEquals(3, $this->entity->getResourceId());
        $this->assertEquals('file', $this->entity->getResourceType());
        $this->assertEquals(4, $this->entity->getVariantId());
    }
}