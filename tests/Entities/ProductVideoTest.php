<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductVideo;
use Tests\BaseTestCase;

class ProductVideoTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductVideo */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new ProductVideo();
        $this->entity
            ->setProductId(1)
            ->setId(2)
            ->setDescription('desc')
            ->setSortOrder(3)
            ->setType('youtube')
            ->setTitle('title')
            ->setLength('10:10')
            ->setVideoId('abc');

        $this->assertEquals(1, $this->entity->getProductId());
        $this->assertEquals(2, $this->entity->getId());
        $this->assertEquals('desc', $this->entity->getDescription());
        $this->assertEquals(3, $this->entity->getSortOrder());
        $this->assertEquals('youtube', $this->entity->getType());
        $this->assertEquals('title', $this->entity->getTitle());
        $this->assertEquals('10:10', $this->entity->getLength());
        $this->assertEquals('abc', $this->entity->getVideoId());
    }
}