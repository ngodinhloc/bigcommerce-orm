<?php
declare(strict_types=1);

namespace Tests;

use Bigcommerce\ORM\Client\Client;
use Bigcommerce\ORM\Entities\Brand;
use Bigcommerce\ORM\Entities\Cart;
use Bigcommerce\ORM\Entities\Channel;
use Bigcommerce\ORM\Entities\Checkout;
use Bigcommerce\ORM\Entities\CheckoutCoupon;
use Bigcommerce\ORM\Entities\Customer;
use Bigcommerce\ORM\Entities\Product;
use Bigcommerce\ORM\Entities\ProductImage;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Exceptions\EntityException;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\QueryBuilder;
use Bigcommerce\ORM\Repository;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EntityManagerTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Client\Client|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $client;

    /** @var \Bigcommerce\ORM\Mapper|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $mapper;

    /** @var \Symfony\Component\EventDispatcher\EventDispatcher|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $dispatcher;

    /** @var \Bigcommerce\ORM\EntityManager */
    protected $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = $this->getClient();
        $this->mapper = $this->getMapper();
        $this->dispatcher = $this->getDispatcher();
        $this->entityManager = new EntityManager($this->client, $this->mapper, $this->dispatcher);
    }

    public function testSettersAndGetters()
    {
        $this->entityManager = new EntityManager($this->client, $this->mapper, $this->dispatcher);
        $this->entityManager
            ->setClient($this->client)
            ->setMapper($this->mapper)
            ->setEventDispatcher($this->dispatcher);

        $this->assertEquals($this->client, $this->entityManager->getClient());
        $this->assertEquals($this->mapper, $this->entityManager->getMapper());
        $this->assertEquals($this->dispatcher, $this->entityManager->getEventDispatcher());
    }

    public function testFindAll()
    {
        $class = Customer::class;
        $pathParams = [];
        $order = ['date_created' => 'asc'];
        $expectedResult = [];
        $findAll = $this->entityManager->findAll($class, $pathParams, $order, false);

        $this->assertEquals($expectedResult, $findAll);
    }

    public function testFindBy()
    {
        $class = Customer::class;
        $pathParams = null;
        $queryBuilder = new QueryBuilder();
        $queryBuilder->whereIn('id', [1, 2, 3]);
        $expectedResult = [];
        $findBy = $this->entityManager->findBy($class, $pathParams, $queryBuilder, false);

        $this->assertEquals($expectedResult, $findBy);
    }

    public function testFind()
    {
        $class = Product::class;
        $pathParams = null;
        $expectedId = 1;
        $customer = $this->entityManager->find($class, $expectedId, $pathParams, true);

        $this->assertInstanceOf(Product::class, $customer);
        $this->assertEquals($expectedId, $customer->getId());

        $result = $this->entityManager->find(Channel::class, 1, null);
        $this->assertFalse($result);

        $channel = $this->entityManager->find(Channel::class, 2, null);
        $this->assertInstanceOf(Channel::class, $channel);

        $channel = $this->entityManager->find(Channel::class, 2, null, true);
        $this->assertInstanceOf(Channel::class, $channel);

    }

    public function testFindProduct()
    {
        /** @var Product $product */
        $product = $this->entityManager->find(Product::class, 1, null, true);
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals(1, $product->getId());
        $primaryImage = $product->getPrimaryImage();
        $this->assertInstanceOf(ProductImage::class, $primaryImage);
        $images = $product->getImages();
        $this->assertEquals(1, count($images));

        $product = $this->entityManager->find(Product::class, 1, null, false);
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals(1, $product->getId());
    }

    public function testFindThrowException()
    {
        $this->expectException(EntityException::class);
        $this->entityManager->find(Customer::class, 1, null, false);
    }

    public function testCreateThrowException()
    {
        $customer = $this->getCustomer();
        $this->expectException(EntityException::class);
        $this->entityManager->save($customer);
    }

    public function testCreateRequiredFields()
    {
        $product = new Product();
        $product->setDescription('Desc');
        $this->expectException(EntityException::class);
        $this->entityManager->save($product);
    }

    public function testCreate()
    {
        $product = new Product();
        $product->setDescription('Desc')->setName('name');
        $this->entityManager->save($product);
        $this->assertEquals(1, $product->getId());
    }

    public function testCreateEmptyFalse()
    {
        $brand = new Brand();
        $brand->setName('name');
        $result = $this->entityManager->save($brand);
        $this->assertFalse($result);
    }

    public function testCreateEmpty()
    {
        $product = new Product();
        $this->expectException(EntityException::class);
        $this->entityManager->save($product);
    }

    public function testSaveThrowException()
    {
        $customer = new Customer();
        $customer->setEmail('invalidEmail');
        $this->expectException(EntityException::class);
        $this->entityManager->save($customer);
    }

    public function testUpdate()
    {
        $customer = $this->getCustomer();
        $customer->setId(1);
        $data = [
            'company' => 'BC',
            'first_name' => 'Ken',
            'last_name' => 'Ngo',
            'email' => 'ken.ngo@bigcommmerce.com',
            'phone' => '0123456789'
        ];
        $this->entityManager->update($customer, $data);
        $this->assertEquals(1, $customer->getId());
    }

    public function testUpdateWithData()
    {
        $file = __DIR__ . '/assets/images/lamp.jpg';
        $image = new ProductImage();
        $image->setProductId(111)->setId(1)->setImageFile($file);
        $this->entityManager->save($image);
        $this->assertEquals(1, $image->getId());
    }

    public function testUpdateWithInvalidFiles()
    {
        $file = __DIR__ . '/assets/images/lamp1.jpg';
        $image = new ProductImage();
        $image->setProductId(111)->setId(1)->setImageFile($file);
        $this->expectException(EntityException::class);
        $this->entityManager->save($image);
    }

    public function testUpdateWithUpdatable()
    {
        $coupon = new CheckoutCoupon();
        $coupon->setId(1)->setCode('code');
        $this->expectException(EntityException::class);
        $this->entityManager->save($coupon);
    }

    public function testUpdateEarlyReturn()
    {
        $image = new ProductImage();
        $image->setId(1);
        $result = $this->entityManager->update($image, []);
        $this->assertEquals(true, $result);

        $image->setProductId(2);
        $result = $this->entityManager->update($image, ['product_id' => null]);
        $this->assertTrue($result);
    }

    public function testUpdateThrowRequiredValidation()
    {
        $customer = new Customer();
        $customer->setId(1)->setEmail('invalid');
        $this->expectException(EntityException::class);
        $this->entityManager->update($customer, ['company' => 'BC']);
    }

    public function testDelete()
    {
        $customer = new Customer();
        $customer->setId(100);
        $result = $this->entityManager->delete($customer, null);
        $this->assertTrue($result);
    }

    public function testDeleteNoParamField()
    {
        $customer = new Customer();
        $this->expectException(EntityException::class);
        $this->entityManager->delete($customer);
    }

    public function testBatchDelete()
    {
        $result = $this->entityManager->batchDelete(Customer::class, null, [1, 2], null);
        $this->assertTrue($result);
    }

    public function testBatchDeleteEmpty()
    {
        $result = $this->entityManager->batchDelete(Customer::class, null, []);
        $this->assertFalse($result);
    }

    public function testDeleteThrowException()
    {
        $this->expectException(EntityException::class);
        $result = $this->entityManager->batchDelete(Channel::class, null, [1, 2]);
    }

    public function testBatchCreate()
    {
        $data = $this->getBatchCreateData();
        $customer1 = $this->entityManager->new(Customer::class, $data[0]);
        $customer2 = $this->entityManager->new(Customer::class, $data[1]);
        $customers = $this->entityManager->batchCreate([$customer1, $customer2]);
        $this->assertEquals(2, count($customers));

        $result = $this->entityManager->batchCreate([]);
        $this->assertFalse($result);
    }

    public function testBatchCreateReturnFalse()
    {
        $data = $this->getBatchCreateData();
        $checkout1 = $this->entityManager->new(Checkout::class, $data[0]);
        $checkout2 = $this->entityManager->new(Checkout::class, $data[1]);
        $result = $this->entityManager->batchCreate([$checkout1, $checkout2]);
        $this->assertFalse($result);
    }

    public function testBatchCreateReturnTrue()
    {
        $data = $this->getBatchCreateData();
        $cart1 = $this->entityManager->new(Cart::class, $data[0]);
        $cart2 = $this->entityManager->new(Cart::class, $data[1]);
        $result = $this->entityManager->batchCreate([$cart1, $cart2]);
        $this->assertTrue($result);
    }

    public function testBatchCreateThrowException()
    {
        $data = $this->getBatchCreateData();
        $customer1 = $this->entityManager->new(Customer::class, $data[0]);
        $checkout2 = $this->entityManager->new(Checkout::class, $data[1]);
        $this->expectException(EntityException::class);
        $result = $this->entityManager->batchCreate([$customer1, $checkout2]);
    }

    public function testBatchUpdateEmpty()
    {
        $data = $this->getBatchCreateData();
        $customer1 = new Customer();
        $customer2 = new Customer();
        $customer1 = $this->mapper->patch($customer1, $data[0], null, true);
        $customer2 = $this->mapper->patch($customer2, $data[1], null, true);

        $result = $this->entityManager->batchUpdate([$customer1, $customer2]);
        $this->assertEquals(false, $result);
    }

    public function testBatchUpdateMissingRequiredValidations()
    {
        $customer1 = new Customer();
        $customer2 = new Customer();
        $customer1->setId(1)->setFirstName('Ken')->setEmail('invalidemail');
        $customer2->setId(2)->setFirstName('Ngo')->setEmail('invalidemail');

        $this->expectException(EntityException::class);
        $result = $this->entityManager->batchUpdate([$customer1, $customer2]);
    }

    public function testBatchUpdateDifferentClass()
    {
        $data = $this->getBatchCreateData();
        $customer1 = new Customer();
        $customer1 = $this->mapper->patch($customer1, $data[0], null, true);
        $product = new Product();

        $this->expectException(EntityException::class);
        $this->entityManager->batchUpdate([$customer1, $product]);
    }

    public function testBatchUpdate()
    {

        $data = $this->getBatchReturnedData();
        $customer1 = new Customer();
        $customer2 = new Customer();
        $customer1 = $this->mapper->patch($customer1, $data[0], null, true);
        $customer2 = $this->mapper->patch($customer2, $data[1], null, true);

        $customers = $this->entityManager->batchUpdate([$customer1, $customer2]);
        $this->assertEquals(2, count($customers));
    }

    public function testBatchUpdateReturnTrue()
    {
        $cart1 = new Cart();
        $cart2 = new Cart();
        $result = $this->entityManager->batchUpdate([$cart1, $cart2]);
        $this->assertTrue($result);
    }

    public function testNew()
    {
        /** @var Customer $customer */
        $customer = $this->entityManager->new(Customer::class, $data = [
            'company' => 'BC',
            'first_name' => 'Ken',
            'last_name' => 'Ngo',
            'email' => 'ken.ngo@bigcommmerce.com',
            'phone' => '0123456789'
        ]);
        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals('BC', $customer->getCompany());
    }

    public function testPatch()
    {
        $customer = new Customer();
        $data = [
            'company' => 'BC',
            'first_name' => 'Ken',
            'last_name' => 'Ngo',
            'email' => 'ken.ngo@bigcommmerce.com',
            'phone' => '0123456789'
        ];
        $customer = $this->entityManager->patch($customer, $data);
        $this->assertEquals('BC', $customer->getCompany());
    }

    public function testToArray()
    {
        $customer = new Customer();
        $data = [
            'company' => 'BC',
            'first_name' => 'Ken',
            'last_name' => 'Ngo',
            'email' => 'ken.ngo@bigcommmerce.com',
            'phone' => '0123456789'
        ];
        $customer = $this->entityManager->patch($customer, $data);
        $array = $this->entityManager->toArray($customer);
        $this->assertArrayHasKey('company', $array);
    }

    public function testGetRepository()
    {
        $repo = $this->entityManager->getRepository(Customer::class);
        $this->assertInstanceOf(Repository::class, $repo);
    }

    /**
     * @return object|\Prophecy\Prophecy\ProphecySubjectInterface
     */
    private function getClient()
    {
        $countPath = '/customers';
        $countReturn = 2;

        $findAllPath = '/customers?sort=date_created:asc&include=addresses';
        $findAllResult = [];

        $findByPath = '/customers?id:in=1,2,3&include=addresses';
        $findByResult = [];

        $findPath = '/products/1?include=primary_image,images,variants,custom_fields,modifiers,options';
        $findResult = ['id' => 1];

        $savePath = '/customers';
        $data = [
            'company' => 'BC',
            'first_name' => 'Ken',
            'last_name' => 'Ngo',
            'email' => 'ken.ngo@bigcommmerce.com',
            'phone' => '0123456789'
        ];
        $productPath = '/catalog/products';
        $returnProduct = [
            'id' => 1,
            'name' => 'Product Name',
            'type' => 'physic',
        ];
        $createResult = [
            'id' => 1,
            'company' => 'BC',
            'first_name' => 'Ken',
            'last_name' => 'Ngo',
            'email' => 'ken.ngo@bigcommmerce.com',
            'phone' => '0123456789'
        ];
        $updatePath = '/customers/1';

        $findProduct = '/catalog/products/1?include=primary_image,images,variants,custom_fields,modifiers,options';
        $findReview = '/catalog/products/1/reviews?product_id:in=1';

        $updateImage = '/catalog/products/111/images/1';

        $file = __DIR__ . '/assets/images/lamp.jpg';
        $files = ["image_file" => $file];
        $reviews = [
            [
                'product_id' => 1,
                'title' => 'Title',
                'text' => 'some text'
            ],
        ];

        $deletePath = '/customers?id:in=1,2';
        $channelPath = '/channels/1?';

        $client = $this->prophet->prophesize(Client::class);
        $client->findAll($findAllPath, 'api')->willReturn($findAllResult);
        $client->findBy($findByPath, 'api')->willReturn($findByResult);
        $client->findBy($findReview, 'api')->willReturn($reviews);
        $client->find($findPath, 'api')->willReturn($findResult);
        $client->find($findProduct, 'api')->willReturn($this->getProductData());
        $client->find($channelPath, 'api')->willReturn([]);
        $client->find('/channels/2?', 'api')->willReturn(['id' => 2]);
        $client->create($savePath, 'api', $data, [])->willReturn($returnProduct);
        $client->create($productPath, 'api', Argument::any(), [])->willReturn($returnProduct);
        $client->create('/customers/addresses', 'api', [], null, true)->willReturn([]);
        $client->create('/channels', 'api', Argument::any(), null, true)->willReturn(false);
        $client->create('/catalog/brands', 'api', Argument::any(), [])->willReturn(false);
        $client->update($updatePath, 'api', $data, [])->willReturn($createResult);
        $client->update($updateImage, 'api', $this->getImageData(), $files)->willReturn(['id' => 1]);
        $client->delete($deletePath, 'api')->willReturn(true);
        $client->delete('/customers/100', 'api')->willReturn(true);
        $client->create($savePath, 'api', $this->getBatchCreateData(), null, true)->willReturn($this->getBatchReturnedData());
        $client->create('/carts', 'api', Argument::any(), null, true)->willReturn($this->getBatchReturnedEmptyId());
        $client->create('/checkouts', 'api', Argument::any(), null, true)->willReturn(false);
        $client->update($savePath, 'api', [], null, true)->willReturn([]);
        $client->update($savePath, 'api', $this->getBatchReturnedData(), null, true)->willReturn($this->getBatchReturnedData());
        $client->update('/carts', 'api', Argument::any(), null, true)->willReturn($this->getBatchReturnedEmptyId());
        $client->update('/catalog/products/2/images/1', 'api', Argument::any(), [])->willReturn(['id' => 1]);

        return $client->reveal();
    }

    private function getImageData()
    {
        $file = __DIR__ . '/assets/images/lamp.jpg';

        return $imageData = [
            "is_thumbnail" => false,
            "sort_order" => null,
            "description" => null,
            "image_file" => $file,
            "image_url" => null,
            "url_zoom" => null,
            "url_standard" => null,
            "url_thumbnail" => null,
            "url_tiny" => null,
            "date_modified" => null
        ];
    }

    private function getBatchReturnedData()
    {
        return [
            [
                'id' => 1,
                'email' => 'ken7.ngo@bc.com',
                'first_name' => 'Ken',
                'last_name' => 'Ngo',
                'company' => 'BC',
                'phone' => '123456789'
            ],
            [
                'id' => 2,
                'email' => 'ken8.ngo@bc.com',
                'first_name' => 'Ken',
                'last_name' => 'Ngo',
                'company' => 'BC',
                'phone' => '123456789'
            ]
        ];
    }

    private function getBatchReturnedEmptyId()
    {
        return [
            [
                'email' => 'ken7.ngo@bc.com',
                'first_name' => 'Ken',
                'last_name' => 'Ngo',
                'company' => 'BC',
                'phone' => '123456789'
            ],
            [
                'email' => 'ken8.ngo@bc.com',
                'first_name' => 'Ken',
                'last_name' => 'Ngo',
                'company' => 'BC',
                'phone' => '123456789'
            ]
        ];
    }

    private function getBatchCreateData()
    {
        return [
            [
                'email' => 'ken7.ngo@bc.com',
                'first_name' => 'Ken',
                'last_name' => 'Ngo',
                'company' => 'BC',
                'phone' => '123456789'
            ],
            [
                'email' => 'ken8.ngo@bc.com',
                'first_name' => 'Ken',
                'last_name' => 'Ngo',
                'company' => 'BC',
                'phone' => '123456789'
            ]
        ];
    }

    private function getProductData()
    {
        return [
            'id' => 1,
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
            ],
            'videos' => [
                [
                    'type' => 'Youtube',
                    'title' => 'Welcome',
                ]
            ]
        ];
    }

    private function getCustomer()
    {
        $customer = new Customer();
        $mapper = $this->getMapper();
        $customer = $mapper->patch(
            $customer,
            [
                'company' => 'BC',
                'first_name' => 'Ken',
                'last_name' => 'Ngo',
                'email' => 'ken.ngo@bigcommmerce.com',
                'phone' => '0123456789'
            ]
        );

        return $customer;
    }

    /**
     * @return \Bigcommerce\ORM\Mapper
     */
    private function getMapper()
    {
        return new Mapper();
    }

    /**
     * @return object|\Prophecy\Prophecy\ProphecySubjectInterface
     */
    private function getDispatcher()
    {
        return new EventDispatcher();
    }
}