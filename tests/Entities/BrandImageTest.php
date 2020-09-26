<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\BrandImage;
use Tests\BaseTestCase;

class BrandImageTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\BrandImage */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new BrandImage();
        $this->entity
            ->setImageUrl('url')
            ->setId(1)
            ->setImageFile('file')
            ->setBrandId(3);

        $this->assertEquals('url', $this->entity->getImageUrl());
        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('file', $this->entity->getImageFile());
        $this->assertEquals(3, $this->entity->getBrandId());
    }
}