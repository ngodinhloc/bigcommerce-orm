<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Category;
use Tests\BaseTestCase;

class CategoryTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\Category */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new Category();
        $parent = new Category();
        $parent->setId(2);
        $this->entity
            ->setId(1)
            ->setName('Name')
            ->setSortOrder(1)
            ->setDescription('Description')
            ->setPageTitle('Title')
            ->setParentId(1)
            ->setParent($parent);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('Name', $this->entity->getName());
        $this->assertEquals(1, $this->entity->getSortOrder());
        $this->assertEquals('Description', $this->entity->getDescription());
        $this->assertEquals('Title', $this->entity->getPageTitle());
        $this->assertEquals(1, $this->entity->getParentId());
        $this->assertEquals($parent, $this->entity->getParent());
    }
}