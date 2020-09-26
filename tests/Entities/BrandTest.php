<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Brand;
use Tests\BaseTestCase;

class BrandTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\Brand */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new Brand();
        $this->entity
            ->setName('name')
            ->setId(1)
            ->setImageUrl('url')
            ->setPageTitle('title')
            ->setCustomUrl(['custom'])
            ->setMetaDescription('meta')
            ->setMetaKeywords(['keywords'])
            ->setSearchKeywords('search');

        $this->assertEquals('name', $this->entity->getName());
        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('url', $this->entity->getImageUrl());
        $this->assertEquals('title', $this->entity->getPageTitle());
        $this->assertEquals(['custom'], $this->entity->getCustomUrl());
        $this->assertEquals('meta', $this->entity->getMetaDescription());
        $this->assertEquals(['keywords'], $this->entity->getMetaKeywords());
        $this->assertEquals('search', $this->entity->getSearchKeywords());
        $this->assertFalse($this->entity->isNew());
    }
}