<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ShippingOption;
use Tests\BaseTestCase;

class ShippingOptionTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\ShippingOption */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new ShippingOption();
        $this->entity
            ->setId(1)
            ->setType('type')
            ->setDescription('desc')
            ->setImageUrl('url')
            ->setAdditionalDescription('add')
            ->setCost(0)
            ->setTransitTime('time');

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('type', $this->entity->getType());
        $this->assertEquals('desc', $this->entity->getDescription());
        $this->assertEquals('url', $this->entity->getImageUrl());
        $this->assertEquals('add', $this->entity->getAdditionalDescription());
        $this->assertEquals(0, $this->entity->getCost());
        $this->assertEquals('time', $this->entity->getTransitTime());
    }
}
