<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CategoryMetafield;
use Tests\BaseTestCase;

class CategoryMetafieldTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CategoryMetafield */
    protected $meta;

    public function testSettersAndGetters()
    {
        $this->meta = new CategoryMetafield();
        $this->meta
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

        $this->assertEquals(1, $this->meta->getCategoryId());
        $this->assertEquals(2, $this->meta->getId());
        $this->assertEquals('desc', $this->meta->getDescription());
        $this->assertEquals('2020-09-16', $this->meta->getDateCreated());
        $this->assertEquals('2020-09-17', $this->meta->getDateModified());
        $this->assertEquals('key', $this->meta->getKey());
        $this->assertEquals('123', $this->meta->getValue());
        $this->assertEquals('namespace', $this->meta->getNamespace());
        $this->assertEquals('perm', $this->meta->getPermissionSet());
        $this->assertEquals(10, $this->meta->getResourceId());
        $this->assertEquals('type', $this->meta->getResourceType());
    }
}