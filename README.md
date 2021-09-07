# Bigcommerce ORM
[![Software license][ico-license]](README.md)
[![Build status][ico-travis]][link-travis]
[![Coverage][ico-codecov]][link-codecov]

[ico-license]: https://img.shields.io/github/license/nrk/predis.svg?style=flat-square
[ico-travis]: https://travis-ci.com/ngodinhloc/bigcommerce-orm.svg?branch=master
[ico-codecov]: https://codecov.io/gh/ngodinhloc/bigcommerce-orm/branch/master/graph/badge.svg

[link-travis]: https://travis-ci.com/github/ngodinhloc/bigcommerce-orm
[link-codecov]: https://codecov.io/gh/ngodinhloc/bigcommerce-orm


Bigcommerce ORM (bigcommerce-orm) allows users to work with Bigcommerce v3-rest-api just like working with an orm. 
Bigcommerce-orm supports:
- working with multiple store manager
- customised entities and repositories
- batch create and batch update
- caching
- event dispatching
- logging
- debugging

## Installation
composer.json
<pre>
"require": {
        "bigcommerce/orm": "^1.0.0"
},
"repositories": [
    { "type": "vcs", "url": "https://github.com/ngodinhloc/bigcommerce-orm" }
],
</pre>

Run 
<pre>
composer require bigcommerce/orm:1.0.0
</pre>

## Configuration
### Simple configs
```php
/** Legacy credentials */
$basicCredentials = [
    'storeUrl' => 'https://store-velgoi8q0k.mybigcommerce.com',
    'username' => '***',
    'apiKey' => '***'
];
$config = new \Bigcommerce\ORM\Configuration($basicCredentials);
$entityManager = $config->configEntityManager();

/** Auth credentials */
$authCredentials = [
    'clientId' => '***',
    'authToken' => '***',
    'storeHash' => '***',
    'baseUrl' => 'https://api.bigcommerce.com'
];
$config = new \Bigcommerce\ORM\Configuration($authCredentials);
$entityManager = $config->configEntityManager();
```

@see: [samples/_simple_config.php](./samples/_simple_config.php)

### Full configs
```php
$authCredentials = [
    'clientId' => '***',
    'authToken' => '***',
    'storeHash' => '***',
    'baseUrl' => 'https://api.bigcommerce.com'
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

@see: [samples/_full_config.php](./samples/_full_config.php)

### Multiple store managers
```php
/** config multiple store managers */
$firstCredential = [
    'storeUrl' => 'https://store-velgoi8q0k.mybigcommerce.com',
    'username' => '***',
    'apiKey' => '***'
];

$configuration = new Bigcommerce\ORM\Configuration($firstCredential);
$firstEntityManger = $configuration->configEntityManager();

$secondCredential = [
    'clientId' => '***',
    'authToken' => '***',
    'storeHash' => '***',
    'baseUrl' => 'https://api.bigcommerce.com'
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

@see: [samples/working_with_multiple_managers.php](./samples/working_with_multiple_managers.php)

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

@see: [samples/working_with_entities.php](./samples/working_with_entities.php)

### Customised entities
If users add customised fields, which only they know of, 
then they can extend the standard entities to add their customised fields

```php
namespace Samples\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entities\Product;

/**
 * Class MyProduct
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

@see: [samples/working_with_customised_entities.php](./samples/working_with_customised_entities.php)

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
$array1 = $entityManager->toArray($review1, \Bigcommerce\ORM\Mapper\EntityTransformer::KEY_BY_FIELD_NAME);

/** return array of entity : key by property name */
$array2 = $entityManager->toArray($review1, \Bigcommerce\ORM\Mapper\EntityTransformer::KEY_BY_PROPERTY_NAME);
```

@see: [samples/working_with_entities.php](./samples/working_with_entities.php)

### Save and Update Entities
```php
/** create one product */
$newProduct = new \Bigcommerce\ORM\Entities\Product();
$newProduct
    ->setDescription('New product description')
    ->setName('New Product 2')
    ->setType('digital')
    ->setWeight(1)
    ->setWidth(10)
    ->setDepth(5)
    ->setHeight(20)
    ->setSku('sku2')
    ->setPrice(100)
    ->setBrandId(0)
    ->setCategoryIds([18, 21]);
$entityManager->save($newProduct);
echo $newProduct->getId();

/** update product */
$newProduct->setDescription('This is product 111 description');
$entityManager->save($newProduct);
echo $newProduct->getDateModified();
```

@see: [samples/products.php](./samples/products.php) 
for more examples of how to query, create and update entities

### Batch Create
```php
$data = [
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
$newCustomers = $entityManager->batchCreate(\Bigcommerce\ORM\Entities\Customer::class, null, $data);
```
*** Note: some resources (for example Customer) do not allow to create ONE object using save(), 
so we have to use batchCreate

@see: [samples/customers.php](./samples/customers.php) 

### Batch Update
```php
/** Batch update products */
/** @var \Bigcommerce\ORM\Entities\Product $product1 */
$product1 = $someProducts[0];
$product2 = $someProducts[1];
$product1->setDescription('New Description');
$product2->setDescription('New Description');
$entityManager->batchUpdate([$product1, $product2]);
```
@see: [samples/products.php](./samples/products.php) 

### Query objects: findAll, findBy, find
```php
/** get all customers */
$allCustomers = $entityManager->findAll(\Bigcommerce\ORM\Entities\Customer::class);

/** get some customers by queries */
$queryBuilder = new \Bigcommerce\ORM\QueryBuilder();
$queryBuilder
    ->whereIn('id', [1, 2])
    ->whereLike('name', 'Ken1')
    ->page(1)->limit(50)
    ->orderBy('date_created', 'desc')
    ->order(['last_name' => 'asc']);
$someCustomers = $entityManager->findBy(\Bigcommerce\ORM\Entities\Customer::class, null, $queryBuilder);

/** get one customer by id */
/** @var \Bigcommerce\ORM\Entities\Customer $customer3 */
$customer3 = $entityManager->find(\Bigcommerce\ORM\Entities\Customer::class, 1);

```
@see: [samples/customers.php](./samples/customers.php)

### Repositories
```php
$customerRepo = new \Bigcommerce\ORM\Repositories\CustomerRepository($entityManager);
$customers = $customerRepo->findAll();
```

@see: [samples/working_with_repositories.php](./samples/working_with_repositories.php)

### Customised Repositories
```php
$myRepo = new \Samples\Repositories\MyRepository($entityManager);
$count = $myRepo->count();
````

@see: [samples/working_with_customised_repositories.php](./samples/working_with_customised_repositories.php)

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
The Configuration accepts a \Psr\Cache\CacheItemPoolInterface to use as a cache engine. bigcommerce-orm includes a built-int cache engine named FileCachePool 
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

### Debug, Verify, Proxy
```php
$options = [
    'verify' => true,
    'timeout' => 60,
    'accept' => 'application/json',
    'debug' => true,
    'proxy' => null
];
```
Bigcommerce-orm will produce useful debug messages:
- Verify peer
```text
* Hostname api.service.bcdev was found in DNS cache
*   Trying 10.133.136.65...
* TCP_NODELAY set
* Connected to api.service.bcdev (10.133.136.65) port 443 (#1)
* ALPN, offering http/1.1
* successfully set certificate verify locations:
*   CAfile: /usr/local/etc/openssl@1.1/cert.pem
  CApath: none
* SSL re-using session ID
* old SSL session ID is stale, removing
* SSL connection using TLSv1.2 / ECDHE-RSA-AES256-GCM-SHA384
* ALPN, server did not agree to a protocol
* Server certificate:
*  subject: C=AU; ST=New South Wales; O=BigCommerce Pty. Ltd.; OU=Technical Operations; CN=*.store.bcdev; emailAddress=serverops@bigcommerce.com
*  start date: Dec 19 23:16:39 2017 GMT
*  expire date: Dec 18 23:16:39 2020 GMT
*  subjectAltName: host "api.service.bcdev" matched cert's "*.service.bcdev"
*  issuer: C=AU; ST=New South Wales; L=Sydney; O=BigCommerce Pty. Ltd.; OU=Technical Operations; CN=BigCommerce Internal Root CA; emailAddress=serverops@bigcommerce.com
*  SSL certificate verify ok.
```
- Request and response
```text
> GET /stores/e87g0h02r5/v3/catalog/products/111/modifiers/116/values HTTP/1.1
Host: api.service.bcdev
User-Agent: GuzzleHttp/7
X-Auth-Client: acxu0p8rfh15m8n0fn4obuxmb52tgwk
X-Auth-Token: cyfbhepc71mns8xnykv86wruxzh45wi
Accept: application/json

< HTTP/1.1 200 OK
< Date: Sun, 13 Sep 2020 23:03:21 GMT
< bc-store-id: 10006319
< X-Request-ID: 2d5e48799e4ed3776125157c2463ef3e
< bc-auth-client: acxu0p8rfh15m8n0fn4obuxmb52tgwk
< X-Rate-Limit-Requests-Left: 447
< X-Rate-Limit-Time-Reset-Ms: 20649
< X-Rate-Limit-Requests-Quota: 450
< X-Rate-Limit-Time-Window-Ms: 30000
< Transfer-Encoding: chunked
< Content-Type: application/json

```

### Sample shopping flow: 
- create shopping cart with one line item 
- add more items to cart: line items, gift certificate and custom items
- get checkout for the created cart
- add a coupon to checkout
- add billing address
- create consignments
- update consignment with shipping option
- create order for the checkout
- get payment access token for the order
- get available payment methods for the order
- made a payment with payment method and credit card
```php
** create cart with one digital line item */
    $newCart = new \Bigcommerce\ORM\Entities\Cart();
    $newCart->setCustomerId(CUSTOMER_ID);

    $lineItem1 = new \Bigcommerce\ORM\Entities\LineItem();
    $lineItem1
        ->setProductId(111)
        ->setQuantity(1);

    $newCart->addLineItem($lineItem1);
    $result = $entityManager->save($newCart);
    echo "Created Cart ID: {$newCart->getId()}" . PHP_EOL;
    echo "Line Item Count:" . count($newCart->getLineItems()) . PHP_EOL;

    /** add more items to cart: line item, gift certificate, custom item */
    $lineItem2 = new \Bigcommerce\ORM\Entities\LineItem();
    $lineItem2
        ->setProductId(107)
        ->setQuantity(1);

    /** gift certificate  */
    $giftCertificate = new \Bigcommerce\ORM\Entities\GiftCertificate();
    $giftCertificate
        ->setQuantity(1)
        ->setAmount(50)
        ->setName('Holiday Card')
        ->setTheme('Birthday')
        ->setMessage('Have a good holidays')
        ->setSender(['name' => 'Ken Ngo', 'email' => 'ken.ngo@bc.com'])
        ->setRecipient(['name' => 'Ken Ngo', 'email' => 'ken2.ngo@bc.com']);

    /** custom item */
    $customItem = new \Bigcommerce\ORM\Entities\CustomItem();
    $customItem
        ->setName('This is my item')
        ->setQuantity(1)
        ->setSku('sku')
        ->setListPrice(100);

    $cartItem = new \Bigcommerce\ORM\Entities\CartItem();
    $cartItem
        ->setCartId($newCart->getId())
        ->addLineItem($lineItem2)
        ->addGiftCertificate($giftCertificate)
        ->addCustomItem($customItem);
    $entityManager->save($cartItem);
    echo "Added Custom Item ID: {$cartItem->getId()}" . PHP_EOL;

    /** find checkout of the created cart */
    $checkout1 = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, $newCart->getId(), null, true);
    /** @var \Bigcommerce\ORM\Entities\Checkout $checkout1 */
    $billingAddress1 = $checkout1->getBillingAddress();
    $consignments1 = $checkout1->getConsignments();
    $coupons1 = $checkout1->getCoupons();
    $cart1 = $checkout1->getCart();
    $digitalItems1 = $cart1->getDigitalItems();
    $physicalItems1 = $cart1->getPhysicalItems();
    $giftCertificates1 = $cart1->getGiftCertificates();
    $customItems1 = $cart1->getCustomItems();
    echo "Cart Coupon Count: " . count($coupons1) . PHP_EOL;
    echo "Digital Item Count: " . count($digitalItems1) . PHP_EOL;
    echo "Physical Item Count: " . count($physicalItems1) . PHP_EOL;
    echo "Gift Certificate Count: " . count($giftCertificates1) . PHP_EOL;
    echo "Custom Item Count: " . count($customItems1) . PHP_EOL;

    /**
     * Add coupon to checkout
     * It seems that one checkout can have ONLY ONE coupon, new coupon added will override old coupon
     */
    $newCoupon = new \Bigcommerce\ORM\Entities\Coupon();
    $newCoupon
        ->setCheckoutId($checkout1->getId())
        ->setCode(COUPON_CODE);
    $entityManager->save($newCoupon);
    echo "Added Coupon ID: {$newCoupon->getId()}" . PHP_EOL;

    /** check for coupon added */
    $checkout2 = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, $newCart->getId(), null, true);
    /** @var \Bigcommerce\ORM\Entities\Checkout $checkout2 */
    $coupons2 = $checkout2->getCoupons();
    echo "Coupon Count:" . count($coupons2) . PHP_EOL;

    /** Add billing address */
    $newBillingAddress = new \Bigcommerce\ORM\Entities\BillingAddress();
    $newBillingAddress
        ->setCheckoutId($checkout1->getId())
        ->setEmail('ken@bc.com')
        ->setFirstName('Ken')
        ->setLastName('Ngo')
        ->setPostalCode('2166')
        ->setStateOrProvince('New South Wales')
        ->setStateOrProvinceCode('NSW')
        ->setCountryCode('AU')
        ->setCountry('Australia')
        ->setCity('Sydney')
        ->setAddressType('resident')
        ->setAddress2('U6')
        ->setAddress1('Longfield');
    $entityManager->save($newBillingAddress);

    /** check for billing address added */
    $checkout2 = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, $newCart->getId(), null, true);
    /** @var \Bigcommerce\ORM\Entities\Checkout $checkout2 */
    $billingAddress2 = $checkout2->getBillingAddress();
    echo "Added Billing Address ID: {$billingAddress2->getId()}" . PHP_EOL;

    /** create new consignments: consignment does not support save(), we have to use batchCreate */
    $newLineItem1 = current($digitalItems1);
    $shippingAddress = $billingAddress2;
    $newConsignment1 = new \Bigcommerce\ORM\Entities\Consignment();
    $newConsignment1
        ->setCheckoutId($checkout2->getId())
        ->addLineItem($newLineItem1)
        ->setShippingAddress($shippingAddress);

    $newConsignment2 = new \Bigcommerce\ORM\Entities\Consignment();
    $newLineItem2 = current($physicalItems1);
    $newCustomItem2 = current($customItems1);
    $newConsignment2
        ->setCheckoutId($checkout2->getId())
        ->addLineItem($newLineItem2)
        ->setShippingAddress($shippingAddress);

    $result = $entityManager->batchCreate([$newConsignment1, $newConsignment2]);
    echo "Consignment Creating Result: {$result}" . PHP_EOL;

    /** check for new consignment added */
    $checkout4 = $entityManager->find(\Bigcommerce\ORM\Entities\Checkout::class, $checkout2->getId(), null, true);
    /** @var \Bigcommerce\ORM\Entities\Checkout $checkout4 */
    $consignments4 = $checkout4->getConsignments();
    echo "Consignment Count: " . count($consignments4) . PHP_EOL;

    /** update consignment with shipping_option_id */
    $consignment4 = current($consignments4);
    $availableShippingOptions = $consignment4->getAvailableShippingOptions();
    $shippingOption = current($availableShippingOptions);

    /** Because shipping option can not be updated along with shipping address and line items */
//    $consignment4->setShippingOption($shippingOption);
//    $entityManager->save($consignment4);

    /** We have to update consignment shipping_option_id using update() */
    $entityManager->update($consignment4, ['shipping_option_id' => $shippingOption->getId()]);
    echo "Shipping Option ID: {$shippingOption->getId()}" . PHP_EOL;

    echo "Checkout ID: {$checkout2->getId()}" . PHP_EOL;

    /** create order for the checkout */
    $order = new \Bigcommerce\ORM\Entities\Order();
    $order->setCheckoutId($checkout2->getId());
    $entityManager->create($order);
    echo "Order ID: {$order->getId()}" . PHP_EOL;

    /** create payment access token for this order */
    $paymentAccessToken = new \Bigcommerce\ORM\Entities\PaymentAccessToken();
    $paymentAccessToken->setOrder($order);
    $entityManager->create($paymentAccessToken);
    echo "Payment Access Token: {$paymentAccessToken->getId()}" . PHP_EOL;

    /** get accepted payment methods for this order */
    $queryBuilder = new \Bigcommerce\ORM\QueryBuilder();
    $queryBuilder->whereEqual('order_id', $order->getId());
    $paymentMethods = $entityManager->findBy(
        \Bigcommerce\ORM\Entities\PaymentMethod::class,
        null,
        $queryBuilder,
        false
    );
    echo "Payment Method Count: " . count($paymentMethods) . PHP_EOL;

    /** @var \Bigcommerce\ORM\Entities\PaymentMethod $paymentMethod */
    $paymentMethod = current($paymentMethods);
    echo "Select Payment Method: {$paymentMethod->getName()}" . PHP_EOL;

    /** made payment for this order */
    $card = new \Bigcommerce\ORM\Entities\Card();
    $card
        ->setType('card')
        ->setCardholderName('Ken Ngo')
        ->setNumber('4111111111111111')
        ->setExpiryMonth(2)
        ->setExpiryYear(2022)
        ->setVerificationValue('111');

    $payment = new \Bigcommerce\ORM\Entities\Payment();
    $payment
        ->setPaymentAccessToken($paymentAccessToken)
        ->setPaymentMethod($paymentMethod)
        ->setPaymentInstrument($card)
        ->setAmount(134)
        ->setCurrencyCode('USD');
    $entityManager->create($payment);
    echo "Payment ID: {$payment->getId()}";
```
@see: [samples/checkouts.php](./samples/checkouts.php)
