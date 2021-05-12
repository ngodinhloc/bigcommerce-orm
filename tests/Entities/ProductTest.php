<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Product;
use Tests\BaseTestCase;

class ProductTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\Product */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new Product();
        $this->entity
            ->setDateModified('2020-09-16')
            ->setDateCreated('2020-09-15')
            ->setId(1)
            ->setDescription('Desc')
            ->setName('Name')
            ->setType('type')
            ->setBrandId(2)
            ->setCategories([])
            ->setCategoryIds([1, 2, 3])
            ->setDepth(5)
            ->setHeight(15)
            ->setImages([])
            ->setPrice(100)
            ->setPrimaryImage(null)
            ->setReviews([])
            ->setSku('sku')
            ->setWeight(10)
            ->setWidth(20)
            ->setVariants([])
            ->setCustomFields([])
            ->setBulkPricingRules([])
            ->setModifiers([])
            ->setOptions([])
            ->setVideos([]);

        $this->assertEquals('2020-09-16', $this->entity->getDateModified());
        $this->assertEquals('2020-09-15', $this->entity->getDateCreated());
        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('Desc', $this->entity->getDescription());
        $this->assertEquals('Name', $this->entity->getName());
        $this->assertEquals('type', $this->entity->getType());
        $this->assertEquals(2, $this->entity->getBrandId());
        $this->assertEquals([], $this->entity->getCategories());
        $this->assertEquals([1, 2, 3], $this->entity->getCategoryIds());
        $this->assertEquals(5, $this->entity->getDepth());
        $this->assertEquals(15, $this->entity->getHeight());
        $this->assertEquals([], $this->entity->getImages());
        $this->assertEquals(100, $this->entity->getPrice());
        $this->assertEquals(null, $this->entity->getPrimaryImage());
        $this->assertEquals([], $this->entity->getReviews());
        $this->assertEquals('sku', $this->entity->getSku());
        $this->assertEquals(10, $this->entity->getWeight());
        $this->assertEquals(20, $this->entity->getWidth());
        $this->assertEquals([], $this->entity->getVariants());
        $this->assertEquals([], $this->entity->getCustomFields());
        $this->assertEquals([], $this->entity->getBulkPricingRules());
        $this->assertEquals([], $this->entity->getModifiers());
        $this->assertEquals([], $this->entity->getOptions());
        $this->assertEquals([], $this->entity->getVideos());
    }
}
