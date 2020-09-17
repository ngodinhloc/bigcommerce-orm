<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CategoryImage;
use Tests\BaseTestCase;

class CategoryImageTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CategoryImage */
    protected $image;

    public function testSettersAndGetters(){
        $this->image = new CategoryImage();
        $this->image
            ->setId(1)
            ->setImageUrl('someurl')
            ->setImageFile('somefile')
            ->setCategoryId(2);

        $this->assertEquals(1, $this->image->getId());
        $this->assertEquals('someurl', $this->image->getImageUrl());
        $this->assertEquals('somefile', $this->image->getImageFile());
        $this->assertEquals(2, $this->image->getCategoryId());
    }
}