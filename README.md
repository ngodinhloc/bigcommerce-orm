# Bigcommerce ORM
[![Software license][ico-license]](README.md)
[![Build status][ico-travis]][link-travis]
[![Coverage][ico-codecov]][link-codecov]

[ico-license]: https://img.shields.io/github/license/nrk/predis.svg?style=flat-square
[ico-travis]: https://travis-ci.com/ngodinhloc/big-orm.svg?branch=master
[ico-codecov]: https://codecov.io/gh/ngodinhloc/big-orm/branch/master/graph/badge.svg

[link-codecov]: https://codecov.io/gh/ngodinhloc/big-orm
[link-travis]: https://travis-ci.com/ngodinhloc/big-orm

Bigcommerce ORM (big-orm) allows users to work with Bigcommerce v3-rest-api just like working with an orm

## Installation
composer.json
<pre>
"require": {
        "bigcommerce/orm": "^1.0.0"
    }
</pre>

Run 
<pre>
composer require bigcommerce/orm
</pre>

## Configuration
### Simple configs
```php
/** Legacy credentials */
$basicCredentials = [
    'storeUrl' => 'https://store-velgoi8q0k.mybigcommerce.com',
    'username' => 'test',
    'apiKey' => '2525df56477f58e5868c240ee5228b0b5d4367c4'
];
$config = new \Bigcommerce\ORM\Configuration($basicCredentials);
$entityManager = $config->configEntityManager();

/** Auth credentials */
$authCredentials = [
    'clientId' => 'acxu0p8rfh15m8n0fn4obuxmb52tgwk',
    'authToken' => 'cyfbhepc71mns8xnykv86wruxzh45wi',
    'storeHash' => 'e87g0h02r5',
    'baseUrl' => 'https://api.service.bcdev'
];
$config = new \Bigcommerce\ORM\Configuration($authCredentials);
$entityManager = $config->configEntityManager();
```

@see: [samples/simple_configs.php](./samples/simple_configs.php)

### Full configs
```php
$authCredentials = [
    'clientId' => 'acxu0p8rfh15m8n0fn4obuxmb52tgwk',
    'authToken' => 'cyfbhepc71mns8xnykv86wruxzh45wi',
    'storeHash' => 'e87g0h02r5',
    'baseUrl' => 'https://api.service.bcdev'
];
$options = [
    'verify' => false,
    'timeout' => 60,
    'contentType' => 'application/json',
    'debug' => true
];
/** cache pool */
$cacheDir = __DIR__ . "/caches/";
$cachePool = new \Bigcommerce\ORM\Cache\FileCache\FileCachePool($cacheDir);

/** event dispatcher */
$eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
$mySubscriber = new \Samples\Events\MySubscriber();
$eventDispatcher->addSubscriber($mySubscriber);

/** logger */
$logFile = __DIR__ . "/logs/monolog.log";
$logger = new \Monolog\Logger('local_logger');
$logger->pushHandler(new \Monolog\Handler\StreamHandler($logFile));

$config = new \Bigcommerce\ORM\Configuration(
            $authCredentials, 
            $options, 
            $cachePool, 
            $eventDispatcher, 
            $logger
        );
$entityManager = $config->configEntityManager();
```

@see: [samples/full_configs.php](./samples/full_configs.php)

### Multiple store managers
```php
/** config multiple store managers */
$firstCredential = [
    'storeUrl' => 'https://store-velgoi8q0k.mybigcommerce.com',
    'username' => 'test',
    'apiKey' => '2525df56477f58e5868c240ee5228b0b5d4367c4'
];

$configuration = new Bigcommerce\ORM\Configuration($firstCredential);
$firstEntityManger = $configuration->configEntityManager();

$secondCredential = [
    'clientId' => 'acxu0p8rfh15m8n0fn4obuxmb52tgwk',
    'authToken' => 'cyfbhepc71mns8xnykv86wruxzh45wi',
    'storeHash' => 'e87g0h02r5',
    'baseUrl' => 'https://api.service.bcdev'
];
$configuration = new Bigcommerce\ORM\Configuration($secondCredential);
$secondEntityManger = $configuration->configEntityManager();

/** using ManagerFactory */
$configs = [
    'firstStore' => [
        'credentials' => $firstCredential
    ],
    'secondStore' => [
        'credentials' => $secondCredential
    ],
];

$managerFactory = new \Bigcommerce\ORM\ManagerFactory($configs);
$firstStoreManager = $managerFactory->getEntityManager('firstStore');
$secondStoreManager = $managerFactory->getEntityManager('secondStore');
```

@see: [samples/multiple_managers.php](./samples/multiple_managers.php)

## Sample codes
### Create entities
```php
/** create new object and set data */
$review1 = new \Bigcommerce\ORM\Entities\ProductReview();
$review1
    ->setProductId(111)
    ->setTitle('Great Product')
    ->setText('I love this product so much')
    ->setStatus('approved')
    ->setRating(5)
    ->setName('Ken Ngo')
    ->setEmail('ken.ngo@bigcommerce.com')
    ->setDateReviewed(date('c'));

/** create object using EntityManager */
$data = [
    'product_id' => 111,
    'title' => 'Very good product',
    'text' => 'I love this product a lot',
    'status' => 'approved',
    'rating' => 5,
    'name' => 'Ken Ngo',
    'email' => 'ken.ngo@bigcommerce.com',
    'date_reviewed' => date('c')
];
$review2 = $entityManager->new(\Bigcommerce\ORM\Entities\ProductReview::class, $data);

/** create new entity then patch it with data */
$review3 = new \Bigcommerce\ORM\Entities\ProductReview();
$review3 = $entityManager->patch($review3, $data);
```

@see: [samples/entities.php](./samples/entities.php)

### Customised entities
If users add customised fields, which only they know of, 
then they can extend the standard entities to add their customised fields
- MyApp\Entities\MyProduct
```php
namespace Samples\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entities\Product;

/**
 * Class CustomisedOrderProduct
 * @package Samples\Entities
 * @BC\BigObject(name="Product", path="/catalog/products")
 */
class MyProduct extends Product
{

    /**
     * @var string
     * @BC\Field(name="my_customised_field", customised=true, readonly=true)
     */
    protected $myCustomisedField;
}
```

@see: [samples/Entities/MyProduct.php](./samples/Entities/MyProduct.php)

### Entities to array
```php
$review1 = new \Bigcommerce\ORM\Entities\ProductReview();
$review1
    ->setProductId(111)
    ->setTitle('Great Product')
    ->setText('I love this product so much')
    ->setStatus('approved')
    ->setRating(5)
    ->setName('Ken Ngo')
    ->setEmail('ken.ngo@bigcommerce.com')
    ->setDateReviewed(date('c'));
    
/** return array of entity : key by field name */
$array1 = $entityManager->toArray($review1, \Bigcommerce\ORM\Mapper::KEY_BY_FIELD_NAME);

/** return array of entity : key by property name */
$array2 = $entityManager->toArray($review1, \Bigcommerce\ORM\Mapper::KEY_BY_PROPERTY_NAME);
```

@see: [samples/entity_to_array.php](./samples/entity_to_array.php)

### Save and Update Entities
```php
/** create a new product review */
$newReview = new \Bigcommerce\ORM\Entities\ProductReview();
$newReview
    ->setProductId($product111->getId())
    ->setTitle('Great Product')
    ->setText('I love this product so much')
    ->setStatus('approved')
    ->setRating(5)
    ->setName('Ken Ngo')
    ->setEmail('ken.ngo@bigcommerce.com')
    ->setDateReviewed(date('c'));
$entityManager->save($newReview);
    
/** update a category */
$category24 = $entityManager->find(\Bigcommerce\ORM\Entities\Category::class, 24);
$category24->setDescription('This is new description');
$entityManager->save($category24);
```

@see: [samples/categories_and_products.php](./samples/categories_and_products.php) 
for more examples of how to query, create and update entities

### Repositories
```php
$customerRepo = new \Bigcommerce\ORM\Repositories\CustomerRepository($entityManager);
$customers = $customerRepo->findAll();
```

@see: [samples/repositories.php](./samples/repositories.php)

### Customised Repositories
```php
$myRepo = new \Samples\Repositories\MyRepository($entityManager);
$count = $myRepo->count();
````

@see: [samples/customised_repositories.php](./samples/customised_repositories.php)

### Validations
```php
class MyProduct extends Entity
{
    /**
     * @var string
     * @BC\Field(name="email", required=true)
     * @BC\Email(validate=true)
     */
    protected $email;

    /**
     * @var string
     * @BC\Field(name="date_created", readonly=true)
     * @BC\Date(format="Y-m-d")
     */
    protected $dateCreated;
}
```

+ @BC\Field(name="email", required=true): indicate that this field is required. An exception will be thrown if a value is not provided when saving the entity.
+ @BC\Field(name="date_created", readonly=true): indicate that this field readonly.
+ @BC\Date(format="Y-m-d"): indicate this field is a Date. An exception will be thrown if provided value is not the in required format.

@see: [samples/Entities/MyProduct.php](./samples/Entities/MyProduct.php)

### Relations
```php
class MyProduct extends Entity
{
    /**
     * @var \Bigcommerce\ORM\Entities\ProductImage
     * @BC\HasOne(name="primary_image", targetClass="\Bigcommerce\ORM\Entities\ProductImage", field="id", targetField="product_id", include=true, auto=true)
     */
    protected $primaryImage;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductImage[]
     * @BC\HasMany(name="images", targetClass="\Bigcommerce\ORM\Entities\ProductImage", field="id", targetField="product_id", include=true, auto=true)
     */
    protected $images;

    /**
     * @var \Bigcommerce\ORM\Entities\Category[]
     * @BC\BelongToMany(name="categories", targetClass="\Bigcommerce\ORM\Entities\Category", field="categories", targetField="id", auto=true)
     */
    protected $categories;

    /**
     * @var \Bigcommerce\ORM\Entities\ProductReview[]
     * @BC\HasMany (name="reviews", targetClass="\Bigcommerce\ORM\Entities\ProductReview", field="id", targetField="product_id", auto=true)
     */
    protected $reviews;
```

@BC\HasOne(name="primary_image", targetClass="\Bigcommerce\ORM\Entities\ProductImage", field="id", targetField="product_id", include=true, auto=true)
+ The product has one primary image, which is an object of class Bigcommerce\ORM\Entities\ProductImage
+ The mapping field is from Product.id to ProductImage.product_id
+ include=true: this resource will be loaded from included resources. If include=false, the resources will be loaded by api. 
+ auto=true: this resource will be loaded when retrieving the product

@BC\HasMany(name="images", targetClass="\Bigcommerce\ORM\Entities\ProductImage", field="id", targetField="product_id", include=true, auto=true)
+ The product has many images, each image is an object of class Bigcommerce\ORM\Entities\ProductImage

@BC\BelongToMany(name="categories", targetClass="\Bigcommerce\ORM\Entities\Category", field="categories", targetField="id", auto=true)
+ The product belongs to many categories, each category is an object of class Bigcommerce\ORM\Entities\Category

@BC\HasMany (name="reviews", targetClass="\Bigcommerce\ORM\Entities\ProductReview", field="id", targetField="product_id", auto=true)
+ The product has many reviews, each review is an object of class Bigcommerce\ORM\Entities\ProductReview

@see: [samples/Entities/MyProduct.php](./samples/Entities/MyProduct.php)

### Working cache
The Configuration accepts a \Psr\Cache\CacheItemPoolInterface to use as a cache engine. Big-orm includes a built-int cache engine named FileCachePool 
```php
$authCredentials = [
    'clientId' => 'acxu0p8rfh15m8n0fn4obuxmb52tgwk',
    'authToken' => 'cyfbhepc71mns8xnykv86wruxzh45wi',
    'storeHash' => 'e87g0h02r5',
    'baseUrl' => 'https://api.service.bcdev'
];

$cacheDir = __DIR__ . "/caches/";
$cachePool = new \Bigcommerce\ORM\Cache\FileCache\FileCachePool($cacheDir);
$config = new \Bigcommerce\ORM\Configuration($authCredentials, null, $cachePool);
$entityManager = $config->configEntityManager();

/** count number of customers */
$count = $entityManager->count(\Bigcommerce\ORM\Entities\Customer::class);
echo $count . PHP_EOL;
```
FileCachePool store caches in json format
```json
{"key":"\/customers","hitCount":2,"cacheTime":1599526337,"expiresAt":null,"expiresAfter":3600,"value":2}
{"key":"\/customers?id:in=1&include=addresses","hitCount":5,"cacheTime":1599526343,"expiresAt":null,"expiresAfter":3600,"value":{"id":1,"address_count":1,"addresses":[{"id":1,"address1":"87 Longfield","address2":"U6","address_type":"residential","city":"Cabramatta","company":"","country":"Australia","country_code":"AU","customer_id":1,"first_name":"Ken","last_name":"Ngo","phone":"","postal_code":"2166","state_or_province":"New South Wales"}],"authentication":{"force_password_reset":false},"company":"","customer_group_id":0,"email":"ken.ngo@bigcommerce.com","first_name":"Ken","last_name":"Ngo","notes":"","phone":"","registration_ip_address":"10.9.0.86","tax_exempt_category":"","date_created":"2020-09-04T04:00:44Z","date_modified":"2020-09-04T04:00:44Z","accepts_product_review_abandoned_cart_emails":true,"channel_ids":[1]}}
```

@see: [samples/working_with_cache.php](./samples/working_with_cache.php)

### Working with event dispatcher
The Configuration accepts a \Symfony\Contracts\EventDispatcher\EventDispatcherInterface to use as event dispatcher. 
The EntityManager emits two events: "Entity.Created" and "Entity.Updated".
```php
$authCredentials = [
    'clientId' => 'acxu0p8rfh15m8n0fn4obuxmb52tgwk',
    'authToken' => 'cyfbhepc71mns8xnykv86wruxzh45wi',
    'storeHash' => 'e87g0h02r5',
    'baseUrl' => 'https://api.service.bcdev'
];

$eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
$mySubscriber = new \Samples\Events\MySubscriber();
$eventDispatcher->addSubscriber($mySubscriber);

$config = new \Bigcommerce\ORM\Configuration($authCredentials, null, null, $eventDispatcher);
$entityManager = $config->configEntityManager();

/** create a new product review */
$newReview = new \Bigcommerce\ORM\Entities\ProductReview();
$newReview
    ->setProductId(111)
    ->setTitle('Great Product')
    ->setText('I love this product so much')
    ->setStatus('approved')
    ->setRating(5)
    ->setName('Ken Ngo')
    ->setEmail('ken.ngo@bigcommerce.com')
    ->setDateReviewed(date('c'));
$entityManager->save($newReview); // Entity.Created will be dispatched

/** update review */
$newReview->setText('I love this product even more');
$entityManager->save($newReview); // Entity.Updated will be dispatched
```

@see: [samples/working_with_event_dispatcher.php](./samples/working_with_event_dispatcher.php)

### Working with logger
The Configuration accepts a \Psr\Log\LoggerInterface to use as logger. 
A debug message will be logged when EntityManager attempts to: query, update or creating objects.
```php
$authCredentials = [
    'clientId' => 'acxu0p8rfh15m8n0fn4obuxmb52tgwk',
    'authToken' => 'cyfbhepc71mns8xnykv86wruxzh45wi',
    'storeHash' => 'e87g0h02r5',
    'baseUrl' => 'https://api.service.bcdev'
];
$logFile = __DIR__ . "/logs/monolog.log";
$logger = new \Monolog\Logger('local_logger');
$logger->pushHandler(new \Monolog\Handler\StreamHandler($logFile));

$config = new \Bigcommerce\ORM\Configuration($authCredentials, null, null, null, $logger);
$entityManager = $config->configEntityManager();

/** get one customer by id */
/** @var \Bigcommerce\ORM\Entities\Customer $customer2 */
$customer2 = $entityManager->find(\Bigcommerce\ORM\Entities\Customer::class, 1);
$addresses2 = $customer2->getAddresses();
$address2 = $addresses2[0];
$country2 = $address2->getCountry();
echo $country2 . PHP_EOL;
```
Sample log messages
```text
[2020-09-08T02:59:28.663848+00:00] local_logger.DEBUG: Start querying objects. Query: /customers [] []
[2020-09-08T02:59:29.085553+00:00] local_logger.DEBUG: Finish querying objects. Query: /customers [] []
[2020-09-08T02:59:29.105161+00:00] local_logger.DEBUG: Start querying objects. Query: /customers?sort=date_created:asc&include=addresses [] []
[2020-09-08T02:59:29.363323+00:00] local_logger.DEBUG: Finish querying objects. Query: /customers?sort=date_created:asc&include=addresses [] []
[2020-09-08T02:59:29.445989+00:00] local_logger.DEBUG: Start querying objects. Query: /customers?id:in=1&include=addresses [] []
[2020-09-08T02:59:29.549405+00:00] local_logger.DEBUG: Finish querying objects. Query: /customers?id:in=1&include=addresses [] []
```

@see: [samples/working_with_logger.php](./samples/working_with_logger.php)