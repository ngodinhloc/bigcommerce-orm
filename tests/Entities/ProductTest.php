<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Product;
use Tests\BaseTestCase;

class ProductTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\Product */
    protected $product;

    public function testSettersAndGetters()
    {
        $this->product = new Product();
        $this->product
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
            ->setWidth(20);

        $this->assertEquals('2020-09-16', $this->product->getDateModified());
        $this->assertEquals('2020-09-15', $this->product->getDateCreated());
        $this->assertEquals(1, $this->product->getId());
        $this->assertEquals('Desc', $this->product->getDescription());
        $this->assertEquals('Name', $this->product->getName());
        $this->assertEquals('type', $this->product->getType());
        $this->assertEquals(2, $this->product->getBrandId());
        $this->assertEquals([], $this->product->getCategories());
        $this->assertEquals([1, 2, 3], $this->product->getCategoryIds());
        $this->assertEquals(5, $this->product->getDepth());
        $this->assertEquals(15, $this->product->getHeight());
        $this->assertEquals([], $this->product->getImages());
        $this->assertEquals(100, $this->product->getPrice());
        $this->assertEquals(null, $this->product->getPrimaryImage());
        $this->assertEquals([], $this->product->getReviews());
        $this->assertEquals('sku', $this->product->getSku());
        $this->assertEquals(10, $this->product->getWeight());
        $this->assertEquals(20, $this->product->getWidth());
    }
}