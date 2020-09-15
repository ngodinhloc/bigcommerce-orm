<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Category;
use Tests\BaseTestCase;

class CategoryTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\Category */
    protected $category;

    public function testSettersAndGetters(){
        $this->category = new Category();
        $parent = new Category();
        $parent->setId(2);
        $this->category
            ->setId(1)
            ->setName('Name')
            ->setSortOrder(1)
            ->setDescription('Description')
            ->setPageTitle('Title')
            ->setParentId(1)
            ->setParent($parent);

        $this->assertEquals(1, $this->category->getId());
        $this->assertEquals('Name', $this->category->getName());
        $this->assertEquals(1, $this->category->getSortOrder());
        $this->assertEquals('Description', $this->category->getDescription());
        $this->assertEquals('Title', $this->category->getPageTitle());
        $this->assertEquals(1, $this->category->getParentId());
        $this->assertEquals($parent, $this->category->getParent());
    }
}