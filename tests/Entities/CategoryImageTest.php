<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CategoryImage;
use Tests\BaseTestCase;

class CategoryImageTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\CategoryImage */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new CategoryImage();
        $this->entity
            ->setId(1)
            ->setImageUrl('someurl')
            ->setImageFile('somefile')
            ->setCategoryId(2);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('someurl', $this->entity->getImageUrl());
        $this->assertEquals('somefile', $this->entity->getImageFile());
        $this->assertEquals(2, $this->entity->getCategoryId());
    }
}
