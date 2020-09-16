<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductImage;
use Tests\BaseTestCase;

class ProductImageTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductImage */
    protected $image;

    public function testSettersAndGetters(){
        $this->image = new ProductImage();
        $this->image
            ->setDescription('Desc')
            ->setId(1)
            ->setDateModified('2020-09-16')
            ->setSortOrder(2)
            ->setImageFile('somefile')
            ->setProductId(111)
            ->setImageUrl('someurl')
            ->setIsThumbnail(true)
            ->setUrlStandard('urlstandard')
            ->setUrlThumbnail('urlthumbnail')
            ->setUrlTiny('urltiny')
            ->setUrlZoom('urlzoom');

        $this->assertEquals('Desc', $this->image->getDescription());
        $this->assertEquals(1, $this->image->getId());
        $this->assertEquals('2020-09-16', $this->image->getDateModified());
        $this->assertEquals(2, $this->image->getSortOrder());
        $this->assertEquals('somefile', $this->image->getImageFile());
        $this->assertEquals(111, $this->image->getProductId());
        $this->assertEquals(true, $this->image->isThumbnail());
        $this->assertEquals('urlstandard', $this->image->getUrlStandard());
        $this->assertEquals('urlthumbnail', $this->image->getUrlThumbnail());
        $this->assertEquals('urltiny', $this->image->getUrlTiny());
        $this->assertEquals('urlzoom', $this->image->getUrlZoom());
        $this->assertEquals('someurl', $this->image->getImageUrl());
    }
}