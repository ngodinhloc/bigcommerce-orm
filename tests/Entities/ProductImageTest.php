<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductImage;
use Tests\BaseTestCase;

class ProductImageTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductImage */
    protected $entity;

    public function testSettersAndGetters(){
        $this->entity = new ProductImage();
        $this->entity
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

        $this->assertEquals('Desc', $this->entity->getDescription());
        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('2020-09-16', $this->entity->getDateModified());
        $this->assertEquals(2, $this->entity->getSortOrder());
        $this->assertEquals('somefile', $this->entity->getImageFile());
        $this->assertEquals(111, $this->entity->getProductId());
        $this->assertEquals(true, $this->entity->isThumbnail());
        $this->assertEquals('urlstandard', $this->entity->getUrlStandard());
        $this->assertEquals('urlthumbnail', $this->entity->getUrlThumbnail());
        $this->assertEquals('urltiny', $this->entity->getUrlTiny());
        $this->assertEquals('urlzoom', $this->entity->getUrlZoom());
        $this->assertEquals('someurl', $this->entity->getImageUrl());
    }
}