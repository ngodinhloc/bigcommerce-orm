<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductVariant;
use Tests\BaseTestCase;

class ProductVariantTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\ProductVariant */
    public $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new ProductVariant();
        $this->entity
            ->setId(1)
            ->setProductId(2)
            ->setOptionValues([])
            ->setImageUrl('url')
            ->setPurchasingDisabledMessage('message')
            ->setPurchasingDisabled(true)
            ->setHeight(10)
            ->setDepth(15)
            ->setWidth(20)
            ->setWeight(25)
            ->setPrice(100)
            ->setSku('sku')
            ->setBinPickingNumber('123')
            ->setCalculatedPrice(110)
            ->setCalculatedWeight(27)
            ->setCostPrice(90)
            ->setFixedCostShippingPrice(30)
            ->setGtin('gtin')
            ->setInventoryLevel(1000)
            ->setInventoryWarningLevel(150)
            ->setIsFreeShipping(true)
            ->setMapPrice(145)
            ->setMpn('mpn')
            ->setUpc('upc')
            ->setSkuId(111)
            ->setRetailPrice(170)
            ->setSalePrice(160);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getProductId());
        $this->assertEquals([], $this->entity->getOptionValues());
        $this->assertEquals('url', $this->entity->getImageUrl());
        $this->assertEquals('message', $this->entity->getPurchasingDisabledMessage());
        $this->assertEquals(true, $this->entity->isPurchasingDisabled());
        $this->assertEquals(10, $this->entity->getHeight());
        $this->assertEquals(15, $this->entity->getDepth());
        $this->assertEquals(20, $this->entity->getWidth());
        $this->assertEquals(25, $this->entity->getWeight());
        $this->assertEquals(100, $this->entity->getPrice());
        $this->assertEquals('sku', $this->entity->getSku());
        $this->assertEquals('123', $this->entity->getBinPickingNumber());
        $this->assertEquals(110, $this->entity->getCalculatedPrice());
        $this->assertEquals(27, $this->entity->getCalculatedWeight());
        $this->assertEquals(90, $this->entity->getCostPrice());
        $this->assertEquals(30, $this->entity->getFixedCostShippingPrice());
        $this->assertEquals('gtin', $this->entity->getGtin());
        $this->assertEquals(1000, $this->entity->getInventoryLevel());
        $this->assertEquals(150, $this->entity->getInventoryWarningLevel());
        $this->assertEquals(true, $this->entity->isFreeShipping());
        $this->assertEquals(145, $this->entity->getMapPrice());
        $this->assertEquals('mpn', $this->entity->getMpn());
        $this->assertEquals('upc', $this->entity->getUpc());
        $this->assertEquals(111, $this->entity->getSkuId());
        $this->assertEquals(170, $this->entity->getRetailPrice());
        $this->assertEquals(160, $this->entity->getSalePrice());
    }
}
