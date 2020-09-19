<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductModifierImage;
use Tests\BaseTestCase;

class ProductModifierImageTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductModifierImage */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new ProductModifierImage();
        $this->entity
            ->setId(1)
            ->setProductId(2)
            ->setImageUrl('url')
            ->setImageFile('file')
            ->setModifierId(3);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getProductId());
        $this->assertEquals('url', $this->entity->getImageUrl());
        $this->assertEquals('file', $this->entity->getImageFile());
        $this->assertEquals(3, $this->entity->getModifierId());
    }
}
