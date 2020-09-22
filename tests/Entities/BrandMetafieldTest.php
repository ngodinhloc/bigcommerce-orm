<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\BrandMetafield;
use Tests\BaseTestCase;

class BrandMetafieldTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\BrandMetafield */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new BrandMetafield();
        $this->entity
            ->setBrandId(1)
            ->setId(2)
            ->setDescription('desc')
            ->setResourceType('type')
            ->setResourceId(3)
            ->setPermissionSet('read')
            ->setNamespace('ns')
            ->setKey('key')
            ->setValue('value')
            ->setDateCreated('2020-09-16')
            ->setDateModified('2020-09-17');

        $this->assertEquals(1, $this->entity->getBrandId());
        $this->assertEquals(2, $this->entity->getId());
        $this->assertEquals('desc', $this->entity->getDescription());
        $this->assertEquals('type', $this->entity->getResourceType());
        $this->assertEquals(3, $this->entity->getResourceId());
        $this->assertEquals('read', $this->entity->getPermissionSet());
        $this->assertEquals('ns', $this->entity->getNamespace());
        $this->assertEquals('key', $this->entity->getKey());
        $this->assertEquals('value', $this->entity->getValue());
        $this->assertEquals('2020-09-16', $this->entity->getDateCreated());
        $this->assertEquals('2020-09-17', $this->entity->getDateModified());
    }
}