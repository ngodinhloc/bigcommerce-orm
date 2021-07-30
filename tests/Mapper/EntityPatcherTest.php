<?php

namespace Tests\Mapper;

use Bigcommerce\ORM\Annotations\Resource;
use Bigcommerce\ORM\Entities\Customer;
use Bigcommerce\ORM\Entities\Product;
use Bigcommerce\ORM\Entities\ProductModifier;
use Bigcommerce\ORM\Exceptions\MapperException;
use Bigcommerce\ORM\Mapper\EntityPatcher;
use Bigcommerce\ORM\Meta\Metadata;
use PHPUnit\Framework\TestCase;

class EntityPatcherTest extends TestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Mapper\EntityPatcher */
    private $patcher;

    protected function setUp(): void
    {
        parent::setUp();
        $this->patcher = new EntityPatcher();
    }

    /**
     * @covers \Bigcommerce\ORM\Mapper\EntityPatcher::getResource
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testGetResource()
    {
        $customer = new Customer();
        $classAnnotation = $this->patcher->getResource($customer);
        $this->assertInstanceOf(Resource::class, $classAnnotation);
        $this->assertEquals('Customer', $classAnnotation->name);
        $this->assertEquals('/customers', $classAnnotation->path);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testObject()
    {
        $object = $this->patcher->object(Customer::class);
        $this->assertInstanceOf(Customer::class, $object);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testObjectThrowException()
    {
        $this->expectException(MapperException::class);
        $this->patcher->object('invalid_class_name');
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testPatch()
    {
        $product = new Product();
        $data = [
            'name' => 'Product Name',
            'type' => 'physic',
            'primary_image' => [
                "id" => 372,
                "product_id" => 111,
                "is_thumbnail" => true,
                "sort_order" => 1,
                "description" => "",
                "image_file" => "lamp.jpg",
            ],
            'images' => [
                [
                    "id" => 372,
                    "product_id" => 111,
                    "is_thumbnail" => false,
                    "sort_order" => 1,
                    "description" => "",
                    "image_file" => "lamp.jpg",
                ],
            ]
        ];

        /** @var Product $product */
        $product = $this->patcher->patch($product, $data);
        $this->assertTrue($product->isPatched());

        $metadata = $product->getMetadata();
        $resource = $metadata->getResource();
        $relationFields = $metadata->getRelationFields();
        $includeFields = $metadata->getIncludeFields();
        $autoLoadFields = $metadata->getAutoLoadFields();
        $requiredFields = $metadata->getRequiredFields();
        $readonlyFields = $metadata->getReadonlyFields();

        $this->assertInstanceOf(Metadata::class, $metadata);
        $this->assertInstanceOf(Resource::class, $resource);
        $this->assertEquals(9, count($relationFields));
        $this->assertEquals(7, count($includeFields));
        $this->assertEquals(2, count($autoLoadFields));
        $this->assertEquals(1, count($requiredFields));
        $this->assertEquals(3, count($readonlyFields));

        $primaryImage = $product->getPrimaryImage();
        $this->assertEquals('lamp.jpg', $primaryImage->getImageFile());

        $modifier = new ProductModifier();
        $modifier = $this->patcher->patch($modifier, ['name' => 'Modifier Name'], ['product_id' => 111]);
        $this->assertTrue($modifier->isPatched());
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testPatchArrayToCollection()
    {
        $array = [
            ['name' => 'Product Name 1', 'type' => 'physic'],
            ['name' => 'Product Name 2', 'type' => 'physic'],
        ];

        $collection = $this->patcher->patchArrayToCollection($array, Product::class);
        $this->assertIsArray($collection);
        /** @var Product $product1 */
        $product1 = $collection[0];
        /** @var Product $product2 */
        $product2 = $collection[1];
        $this->assertInstanceOf(Product::class, $product1);
        $this->assertInstanceOf(Product::class, $product2);
        $this->assertEquals('Product Name 1', $product1->getName());
        $this->assertEquals('Product Name 2', $product2->getName());
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testGetPatchedEntity()
    {
        $entity = $this->patcher->patchFromClass(Product::class);
        $this->assertInstanceOf(Product::class, $entity);
    }
}
