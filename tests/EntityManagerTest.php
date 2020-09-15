<?php
declare(strict_types=1);

namespace Tests;

use Bigcommerce\ORM\Client\Client;
use Bigcommerce\ORM\Entities\Customer;
use Bigcommerce\ORM\Entities\Product;
use Bigcommerce\ORM\Entities\ProductImage;
use Bigcommerce\ORM\EntityManager;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\QueryBuilder;
use Bigcommerce\ORM\Repository;
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

    /**
     * @covers \Bigcommerce\ORM\EntityManager::setClient
     * @covers \Bigcommerce\ORM\EntityManager::setMapper
     * @covers \Bigcommerce\ORM\EntityManager::setEventDispatcher
     * @covers \Bigcommerce\ORM\EntityManager::getClient
     * @covers \Bigcommerce\ORM\EntityManager::getMapper
     * @covers \Bigcommerce\ORM\EntityManager::getEventDispatcher
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
     * @covers \Bigcommerce\ORM\EntityManager::count
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testCount()
    {
        $class = Customer::class;
        $expect = 2;
        $count = $this->entityManager->count($class, []);

        $this->assertEquals($expect, $count);
    }

    /**
     * @covers \Bigcommerce\ORM\EntityManager::findAll
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
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
     * @covers \Bigcommerce\ORM\EntityManager::findBy
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
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
     * @covers \Bigcommerce\ORM\EntityManager::find
     * @throws \Bigcommerce\ORM\Client\Exceptions\ClientException
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testFind()
    {
        $class = Customer::class;
        $pathParams = null;
        $expectedId = 1;
        $customer = $this->entityManager->find($class, $expectedId, $pathParams, true);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals($expectedId, $customer->getId());
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
    }

    public function testCreate()
    {
        $customer = $this->getCustomer();
        $this->entityManager->save($customer);
        $this->assertEquals(1, $customer->getId());
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

        $findPath = '/customers/1?include=addresses';
        $findResult = ['id' => 1];

        $savePath = '/customers';
        $data = [
            'company' => 'BC',
            'first_name' => 'Ken',
            'last_name' => 'Ngo',
            'email' => 'ken.ngo@bigcommmerce.com',
            'phone' => '0123456789'
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

        $findProduct = '/catalog/products/1?include=primary_image,images';
        $findReview = '/catalog/products/1/reviews?product_id:in=1';

        $updateImage = '/catalog/products/111/images/1';

        $file = __DIR__ . '/assets/images/lamp.jpg';
        $files =  ["image_file" => $file];
        $imageData = [
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
        $reviews = [
            [
                'product_id' => 1,
                'title' => 'Title',
                'text' => 'some text'
            ],
        ];

        $client = $this->prophet->prophesize(Client::class);
        $client->count($countPath)->willReturn($countReturn);
        $client->findAll($findAllPath)->willReturn($findAllResult);
        $client->findBy($findByPath)->willReturn($findByResult);
        $client->findBy($findReview)->willReturn($reviews);
        $client->find($findPath)->willReturn($findResult);
        $client->find($findProduct)->willReturn($this->getProductData());
        $client->create($savePath, $data, [])->willReturn($createResult);
        $client->update($updatePath, $data, [])->willReturn($createResult);
        $client->update($updateImage, $imageData, $files)->willReturn(['id' => 1]);

        return $client->reveal();
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
            ]
        ];
    }

    private function getCustomer()
    {
        $customer = new Customer();
        $mapper = $this->getMapper();
        $customer = $mapper->patch($customer, $data = [
            'company' => 'BC',
            'first_name' => 'Ken',
            'last_name' => 'Ngo',
            'email' => 'ken.ngo@bigcommmerce.com',
            'phone' => '0123456789'
        ]);
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