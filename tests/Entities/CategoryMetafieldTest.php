<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CategoryMetafield;
use Tests\BaseTestCase;

class CategoryMetafieldTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CategoryMetafield */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new CategoryMetafield();
        $this->entity
            ->setCategoryId(1)
            ->setId(2)
            ->setDescription('desc')
            ->setDateCreated('2020-09-16')
            ->setDateModified('2020-09-17')
            ->setKey('key')
            ->setValue('123')
            ->setNamespace('namespace')
            ->setPermissionSet('perm')
            ->setResourceId(10)
            ->setResourceType('type');

        $this->assertEquals(1, $this->entity->getCategoryId());
        $this->assertEquals(2, $this->entity->getId());
        $this->assertEquals('desc', $this->entity->getDescription());
        $this->assertEquals('2020-09-16', $this->entity->getDateCreated());
        $this->assertEquals('2020-09-17', $this->entity->getDateModified());
        $this->assertEquals('key', $this->entity->getKey());
        $this->assertEquals('123', $this->entity->getValue());
        $this->assertEquals('namespace', $this->entity->getNamespace());
        $this->assertEquals('perm', $this->entity->getPermissionSet());
        $this->assertEquals(10, $this->entity->getResourceId());
        $this->assertEquals('type', $this->entity->getResourceType());
    }
}