<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductModifierImage;
use Tests\BaseTestCase;

class ProductModifierImageTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductModifierImage */
    protected $image;

    public function testSettersAndGetters()
    {
        $this->image = new ProductModifierImage();
        $this->image
            ->setId(1)
            ->setProductId(2)
            ->setImageUrl('url')
            ->setImageFile('file')
            ->setModifierId(3);

        $this->assertEquals(1, $this->image->getId());
        $this->assertEquals(2, $this->image->getProductId());
        $this->assertEquals('url', $this->image->getImageUrl());
        $this->assertEquals('file', $this->image->getImageFile());
        $this->assertEquals(3, $this->image->getModifierId());
    }
}
