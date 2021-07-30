<?php
declare(strict_types=1);

namespace Tests;

use Bigcommerce\ORM\Client\Client;
use Bigcommerce\ORM\Entities\Brand;
use Bigcommerce\ORM\Entities\Cart;
use Bigcommerce\ORM\Entities\Channel;
use Bigcommerce\ORM\Entities\Checkout;
use Bigcommerce\ORM\Entities\Coupon;
use Bigcommerce\ORM\Entities\Customer;
use Bigcommerce\ORM\Entities\Payment;
use Bigcommerce\ORM\Entities\PaymentAccessToken;
use Bigcommerce\ORM\Entities\Product;
use Bigcommerce\ORM\Entities\ProductImage;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Exceptions\EntityException;
use Bigcommerce\ORM\Mapper\EntityMapper;
use Bigcommerce\ORM\QueryBuilder;
use Bigcommerce\ORM\Repository;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EntityManagerTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\EntityManager */
    protected $entityManager;

    /** @var \Bigcommerce\ORM\Client\Client|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $client;

    /** @var \Bigcommerce\ORM\Mapper\EntityMapper|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $mapper;

    /** @var \Symfony\Component\EventDispatcher\EventDispatcher|\Prophecy\Prophecy\ProphecySubjectInterface */
    protected $dispatcher;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = $this->getClient();
        $this->mapper = $this->getMapper();
        $this->dispatcher = $this->getDispatcher();
        $this->entityManager = new EntityManager($this->client, $this->mapper, $this->dispatcher);
    }

    /**
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
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

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testFindAll()
    {
        $class = Customer::class;
        $pathParams = [];
        $order = ['date_created' => 'asc'];
        $expectedResult = [];
        $findAll = $this->entityManager->findAll($class, $pathParams, $order, false);

        $this->assertEquals($expectedResult, $findAll);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
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

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
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

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
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

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testFindThrowException()
    {
        $this->expectException(EntityException::class);
        $this->entityManager->find(Customer::class, 1, null, false);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testCreateThrowException()
    {
        $customer = $this->getCustomer();
        $this->expectException(EntityException::class);
        $this->entityManager->save($customer);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testCreateRequiredFields()
    {
        $product = new Product();
        $product->setDescription('Desc');
        $this->expectException(EntityException::class);
        $this->entityManager->save($product);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testCreate()
    {
        $product = new Product();
        $product->setDescription('Desc')->setName('name');
        $this->entityManager->save($product);
        $this->assertEquals(1, $product->getId());

        $product = new Product();
        $product->setDescription('Desc')->setName('name');
        $this->entityManager->create($product);
        $this->assertEquals(1, $product->getId());
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testCreateEmptyFalse()
    {
        $brand = new Brand();
        $brand->setName('name');
        $result = $this->entityManager->save($brand);
        $this->assertFalse($result);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testCreateEmpty()
    {
        $product = new Product();
        $this->expectException(EntityException::class);
        $this->entityManager->save($product);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testCreatePaymentThrowException()
    {
        $payment = new Payment();
        $this->expectException(EntityException::class);
        $this->entityManager->create($payment);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testCreatePayment()
    {
        $payment = new Payment();
        $paymentAccessToken = new PaymentAccessToken();
        $paymentAccessToken->setId('123');
        $payment->setPaymentAccessToken($paymentAccessToken);
        $this->expectException(EntityException::class);
        $this->entityManager->create($payment);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testSaveThrowException()
    {
        $customer = new Customer();
        $customer->setEmail('invalidEmail');
        $this->expectException(EntityException::class);
        $this->entityManager->save($customer);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
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

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testUpdateWithData()
    {
        $file = __DIR__ . '/assets/images/lamp.jpg';
        $image = new ProductImage();
        $image->setProductId(111)->setId(1)->setImageFile($file);
        $this->entityManager->save($image);
        $this->assertEquals(1, $image->getId());
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testUpdateWithInvalidFiles()
    {
        $file = __DIR__ . '/assets/images/lamp1.jpg';
        $image = new ProductImage();
        $image->setProductId(111)->setId(1)->setImageFile($file);
        $this->expectException(EntityException::class);
        $this->entityManager->save($image);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testUpdateWithUpdatable()
    {
        $coupon = new Coupon();
        $coupon->setId(1)->setCode('code');
        $this->expectException(EntityException::class);
        $this->entityManager->save($coupon);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
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

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testUpdateThrowRequiredValidation()
    {
        $customer = new Customer();
        $customer->setId(1)->setEmail('invalid');
        $this->expectException(EntityException::class);
        $this->entityManager->update($customer, ['company' => 'BC']);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testDelete()
    {
        $customer = new Customer();
        $customer->setId(100);
        $result = $this->entityManager->delete($customer, null);
        $this->assertTrue($result);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testDeleteNoParamField()
    {
        $customer = new Customer();
        $this->expectException(EntityException::class);
        $this->entityManager->delete($customer);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testBatchDelete()
    {
        $result = $this->entityManager->batchDelete(Customer::class, null, [1, 2], null);
        $this->assertTrue($result);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testBatchDeleteEmpty()
    {
        $result = $this->entityManager->batchDelete(Customer::class, null, []);
        $this->assertFalse($result);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testDeleteThrowException()
    {
        $this->expectException(EntityException::class);
        $this->entityManager->batchDelete(Channel::class, null, [1, 2]);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
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

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testBatchCreateReturnFalse()
    {
        $data = $this->getBatchCreateData();
        $checkout1 = $this->entityManager->new(Checkout::class, $data[0]);
        $checkout2 = $this->entityManager->new(Checkout::class, $data[1]);
        $result = $this->entityManager->batchCreate([$checkout1, $checkout2]);
        $this->assertFalse($result);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testBatchCreateReturnTrue()
    {
        $data = $this->getBatchCreateCartData();
        $cart1 = $this->entityManager->new(Cart::class, $data[0]);
        $cart2 = $this->entityManager->new(Cart::class, $data[1]);
        $result = $this->entityManager->batchCreate([$cart1, $cart2]);
        $this->assertTrue($result);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testBatchCreateThrowException()
    {
        $data = $this->getBatchCreateData();
        $customer1 = $this->entityManager->new(Customer::class, $data[0]);
        $checkout2 = $this->entityManager->new(Checkout::class, $data[1]);
        $this->expectException(EntityException::class);
        $this->entityManager->batchCreate([$customer1, $checkout2]);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testBatchUpdateEmpty()
    {
        $data = $this->getBatchCreateData();
        $customer1 = new Customer();
        $customer2 = new Customer();
        $customer1 = $this->mapper->getEntityPatcher()->patch($customer1, $data[0], null, true);
        $customer2 = $this->mapper->getEntityPatcher()->patch($customer2, $data[1], null, true);

        $result = $this->entityManager->batchUpdate([$customer1, $customer2]);
        $this->assertEquals(false, $result);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testBatchUpdateMissingRequiredValidations()
    {
        $customer1 = new Customer();
        $customer2 = new Customer();
        $customer1->setId(1)->setFirstName('Ken')->setEmail('invalidemail');
        $customer2->setId(2)->setFirstName('Ngo')->setEmail('invalidemail');

        $this->expectException(EntityException::class);
        $this->entityManager->batchUpdate([$customer1, $customer2]);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testBatchUpdateDifferentClass()
    {
        $data = $this->getBatchCreateData();
        $customer1 = new Customer();
        $customer1 = $this->mapper->getEntityPatcher()->patch($customer1, $data[0], null, true);
        $product = new Product();

        $this->expectException(EntityException::class);
        $this->entityManager->batchUpdate([$customer1, $product]);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testBatchUpdate()
    {
        $data = $this->getBatchReturnedData();
        $customer1 = new Customer();
        $customer2 = new Customer();
        $customer1 = $this->mapper->getEntityPatcher()->patch($customer1, $data[0], null, true);
        $customer2 = $this->mapper->getEntityPatcher()->patch($customer2, $data[1], null, true);

        $customers = $this->entityManager->batchUpdate([$customer1, $customer2]);
        $this->assertCount(2, $customers);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testBatchUpdateReturnTrue()
    {
        $cart1 = new Cart();
        $cart2 = new Cart();
        $result = $this->entityManager->batchUpdate([$cart1, $cart2]);
        $this->assertTrue($result);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
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

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
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

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
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

    /**
     * @throws \Exception
     */
    public function testGetRepository()
    {
        $repo = $this->entityManager->getRepository(Customer::class);
        $this->assertInstanceOf(Repository::class, $repo);
    }

    /**
     * testSetPaymentAccessToken
     */
    public function testSetPaymentAccessToken()
    {
        $token = new PaymentAccessToken();
        $token->setId('123');
        $this->entityManager->setPaymentAccessToken($token);
        $this->assertInstanceOf(EntityManager::class, $this->entityManager);
    }

    /**
     * @return object|\Prophecy\Prophecy\ProphecySubjectInterface
     */
    private function getClient()
    {
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

        $findProduct = '/catalog/products/1?include=primary_image,images,variants,custom_fields,modifiers,options,videos';
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
        $client->setPaymentAccessToken('123')->willReturn(true);

        return $client->reveal();
    }

    /**
     * @return array
     */
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

    /**
     * @return array[]
     */
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

    /**
     * @return \string[][]
     */
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

    /**
     * @return \string[][]
     */
    private function getBatchCreateData()
    {
        return [
            [
                'email' => 'ken7.ngo@bc.com',
                'first_name' => 'Ken',
                'last_name' => 'Ngo',
                'company' => 'BC',
                'phone' => '123456789',
            ],
            [
                'email' => 'ken8.ngo@bc.com',
                'first_name' => 'Ken',
                'last_name' => 'Ngo',
                'company' => 'BC',
                'phone' => '123456789',
            ]
        ];
    }

    private function getBatchCreateCartData()
    {
        return [
            [
                'email' => 'ken7.ngo@bc.com',
                'first_name' => 'Ken',
                'last_name' => 'Ngo',
                'company' => 'BC',
                'phone' => '123456789',
                'customer_id' =>3,
            ],
            [
                'email' => 'ken8.ngo@bc.com',
                'first_name' => 'Ken',
                'last_name' => 'Ngo',
                'company' => 'BC',
                'phone' => '123456789',
                'customer_id' => 5,
            ]
        ];
    }

    /**
     * @return array
     */
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

    /**
     * @return \Bigcommerce\ORM\AbstractEntity|null
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    private function getCustomer()
    {
        $customer = new Customer();
        $mapper = $this->getMapper();
        $customer = $mapper->getEntityPatcher()->patch(
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
     * @return \Bigcommerce\ORM\Mapper\EntityMapper
     */
    private function getMapper()
    {
        return new EntityMapper();
    }

    /**
     * @return object|\Prophecy\Prophecy\ProphecySubjectInterface
     */
    private function getDispatcher()
    {
        return new EventDispatcher();
    }
}
