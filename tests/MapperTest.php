<?php
declare(strict_types=1);

namespace Tests;

use Bigcommerce\ORM\Annotations\Resource;
use Bigcommerce\ORM\Entities\CartRedirectUrl;
use Bigcommerce\ORM\Entities\Customer;
use Bigcommerce\ORM\Entities\CustomerAddress;
use Bigcommerce\ORM\Entities\Product;
use Bigcommerce\ORM\Entities\ProductModifier;
use Bigcommerce\ORM\Entities\ProductModifierValue;
use Bigcommerce\ORM\Entities\ProductReview;
use Bigcommerce\ORM\Entities\ShippingAddress;
use Bigcommerce\ORM\Exceptions\EntityException;
use Bigcommerce\ORM\Exceptions\MapperException;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\Metadata;

class MapperTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Mapper */
    protected $mapper;

    /** @var \Bigcommerce\ORM\Entities\Customer */
    protected $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mapper = new Mapper();
        $this->customer = new Customer();
    }

    /**
     * @covers \Bigcommerce\ORM\Mapper::getResource
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testGetClassAnnotation()
    {
        $classAnnotation = $this->mapper->getResource($this->customer);
        $this->assertInstanceOf(Resource::class, $classAnnotation);
        $this->assertEquals('Customer', $classAnnotation->name);
        $this->assertEquals('/customers', $classAnnotation->path);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testResourcePath()
    {
        $path = $this->mapper->getResourcePath($this->customer);
        $this->assertEquals('/customers', $path);

        $review = new ProductReview();
        $review->setProductId(111);
        $path = $this->mapper->getResourcePath($review);
        $this->assertEquals('/catalog/products/111/reviews', $path);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testResourcePathThrowException()
    {
        $value = new ProductModifierValue();
        $value->setProductId(111);
        $this->expectException(MapperException::class);
        $path = $this->mapper->getResourcePath($value);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testResourcePathNotFindable()
    {
        $entity = new CartRedirectUrl();
        $this->expectException(EntityException::class);
        $this->mapper->getResourcePath($entity, 'find');
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testResourcePathNotUpdatable()
    {
        $entity = new CartRedirectUrl();
        $this->expectException(EntityException::class);
        $this->mapper->getResourcePath($entity, 'update');
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testResourcePathNotDeletable()
    {
        $entity = new CartRedirectUrl();
        $this->expectException(EntityException::class);
        $this->mapper->getResourcePath($entity, 'delete');
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testResourcePathNotCreatable()
    {
        $entity = new Customer();
        $this->expectException(EntityException::class);
        $this->mapper->getResourcePath($entity, 'create');
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testResourcePathEmpty()
    {
        $entity = new ShippingAddress();
        $this->expectException(EntityException::class);
        $this->mapper->getResourcePath($entity, 'create');
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
        $product = $this->mapper->patch($product, $data);
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
        $modifier = $this->mapper->patch($modifier, ['name' => 'Modifier Name'], ['product_id' => 111]);
        $this->assertTrue($modifier->isPatched());
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testCheckRequiredFields()
    {
        $product = new Product();
        $check = $this->mapper->checkRequiredFields($product);
        $this->assertEquals(['name' => 'name'], $check);

        $address = new CustomerAddress();
        $check = $this->mapper->checkRequiredFields($address);
        $this->assertEquals(true, $check);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testGetNoneReadonlyData()
    {
        $modifier = new ProductModifier();
        $modifier
            ->setProductId(111)
            ->setSortOrder(2)
            ->setName('name')
            ->setDisplayName('display name')
            ->setType('type')
            ->setConfig(['sku' => 111]);
        $expected = [
            'name' => 'name',
            'display_name' => 'display name',
            'type' => 'type',
            'required' => false,
            'sort_order' => 2,
            'config' => ['sku' => 111]
        ];

        $data = $this->mapper->getWritableFieldValues($modifier, []);
        $this->assertEquals($expected, $data);
    }

    /**
     * testCheckNoneReadOnlyData
     */
    public function testCheckNoneReadOnlyData()
    {
        $expected = [
            'name' => 'name',
            'display_name' => 'display name',
            'type' => 'type',
            'required' => false,
            'sort_order' => 2,
            'config' => ['sku' => 111]
        ];

        $check = $this->mapper->checkFieldValues($expected);
        $this->assertTrue($check);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testCheckRequiredValidations()
    {
        $customer = new Customer();
        $customer->setEmail('kenngo');
        $check = $this->mapper->checkRequiredValidations($customer);
        $expected = [
            'email' => 'email: Bigcommerce\ORM\Annotations\Email'
        ];

        $this->assertEquals($expected, $check);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testToArray()
    {
        $modifier = new ProductModifier();
        $modifier
            ->setName('Name')
            ->setType('file')
            ->setDisplayName('Display Name');
        $expected = [
            'product_id' => null,
            'name' => 'Name',
            'display_name' => 'Display Name',
            'type' => 'file',
            'required' => false,
            'sort_order' => null,
            'config' => null,
            'id' => null
        ];
        $array = $this->mapper->toArray($modifier);
        $this->assertEquals($expected, $array);

        $expected = [
            'productId' => null,
            'name' => 'Name',
            'displayName' => 'Display Name',
            'type' => 'file',
            'required' => false,
            'sortOrder' => null,
            'config' => null,
            'id' => null
        ];

        $array = $this->mapper->toArray($modifier, Mapper::KEY_BY_PROPERTY_NAME);
        $this->assertEquals($expected, $array);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testGetPropertyValueByName()
    {
        $modifier = new ProductModifier();
        $modifier
            ->setName('Name')
            ->setType('file')
            ->setDisplayName('Display Name');
        $value = $this->mapper->getPropertyValueByName($modifier, 'name');
        $this->assertEquals('Name', $value);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testGetPropertyValueByNameThrowException()
    {
        $modifier = new ProductModifier();
        $modifier
            ->setName('Name')
            ->setType('file')
            ->setDisplayName('Display Name');
        $this->expectException(\TypeError::class);
        $this->mapper->getPropertyValueByName($modifier, 'invalid');
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testGetProperty()
    {
        $modifier = new ProductModifier();
        $modifier
            ->setName('Name')
            ->setType('file')
            ->setDisplayName('Display Name');
        $get = $this->mapper->getEntityMapper()->getProperty($modifier, 'invalid');
        $this->assertFalse($get);
    }

    /**
     * testGetPropertyValue
     */
    public function testGetPropertyValue()
    {
        $modifier = new ProductModifier();
        $modifier
            ->setName('Name')
            ->setType('file')
            ->setDisplayName('Display Name');
        $get = $this->mapper->getPropertyValue($modifier, null);
        $this->assertNull($get);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testGetPropertyValueByFieldName()
    {
        $modifier = new ProductModifier();
        $modifier
            ->setName('Name')
            ->setType('file')
            ->setDisplayName('Display Name');
        $value = $this->mapper->getPropertyValueByFieldName($modifier, 'display_name');
        $this->assertEquals('Display Name', $value);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testGetPropertyValueByFieldNameThrowException()
    {
        $modifier = new ProductModifier();
        $modifier
            ->setName('Name')
            ->setType('file')
            ->setDisplayName('Display Name');
        $this->expectException(MapperException::class);
        $this->mapper->getPropertyValueByFieldName($modifier, 'invalid');
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testObject()
    {
        $object = $this->mapper->object(Customer::class);
        $this->assertInstanceOf(Customer::class, $object);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testObjectThrowException()
    {
        $this->expectException(MapperException::class);
        $this->mapper->object('invalid_class_name');
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function testCheckEntity()
    {
        $this->expectException(\TypeError::class);
        $this->mapper->checkEntity(null);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function testCheckClass()
    {
        $this->expectException(EntityException::class);
        $this->mapper->checkClass('');
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function testCheckId()
    {
        $this->expectException(EntityException::class);
        $this->mapper->checkId(0);
    }

    /**
     * testCheckPropertyValues
     */
    public function testCheckPropertyValues()
    {
        $result = $this->mapper->checkFieldValues(null);
        $this->assertFalse($result);
    }
}
