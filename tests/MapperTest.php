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
use Bigcommerce\ORM\Mapper\EntityMapper;
use Bigcommerce\ORM\Meta\Metadata;

class MapperTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Mapper\EntityMapper */
    protected $mapper;

    /** @var \Bigcommerce\ORM\Entities\Customer */
    protected $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mapper = new EntityMapper();
        $this->customer = new Customer();
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
    public function testObject()
    {
        $object = $this->mapper->getEntityPatcher()->object(Customer::class);
        $this->assertInstanceOf(Customer::class, $object);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testObjectThrowException()
    {
        $this->expectException(MapperException::class);
        $this->mapper->getEntityPatcher()->object('invalid_class_name');
    }
}
