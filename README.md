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
<pre>
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
</pre>
@see: [samples/simple_configs.php](./samples/simple_configs.php)

### Full configs
<pre>
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

$config = new \Bigcommerce\ORM\Configuration($authCredentials, $options, $cachePool, $eventDispatcher, $logger);
$entityManager = $config->configEntityManager();
</pre>
@see: [samples/full_configs.php](./samples/full_configs.php)

### Working with multiple store managers
<pre>
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
</pre>
@see: [samples/multiple_managers.php](./samples/multiple_managers.php)

## Sample codes
### Create entities
<pre>
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
</pre>
@see: [samples/entities.php](./samples/entities.php)

### Customised entities
If users add customised fields, which only they know of, 
then they can extend the standard entities to add their customised fields
- MyApp\Entities\CustomisedOrderProduct
<pre>
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
</pre>
@see: [samples/Entities/MyProduct.php](./samples/Entities/MyProduct.php)

### Entities to array
<pre>
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
</pre>
@see: [samples/entity_to_array.php](./samples/entity_to_array.php)

### Save and Update Entities
<pre>
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
</pre>
@see: [samples/categories_and_products.php](./samples/categories_and_products.php) 
for more examples of how to query, create and update entities

### Repositories
<pre>
$customerRepo = new \Bigcommerce\ORM\Repositories\CustomerRepository($entityManager);
$customers = $customerRepo->findAll();
</pre>
@see: [samples/repositories.php](./samples/repositories.php)

### Customised Repositories
<pre>
$myRepo = new \Samples\Repositories\MyRepository($entityManager);
$count = $myRepo->count();
</pre>
@see: [samples/customised_repositories.php](./samples/customised_repositories.php)

### Validations
<pre>
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
</pre>
+ @BC\Field(name="email", required=true): indicate that this field is required. An exception will be thrown if a value is not provided when saving the entity.
+ @BC\Field(name="date_created", readonly=true): indicate that this field readonly.
+ @BC\Date(format="Y-m-d"): indicate this field is a Date. An exception will be thrown if provided value is not the in required format.

@see: [samples/Entities/MyProduct.php](./samples/Entities/MyProduct.php)

### Relations
<pre>
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
</pre>

@BC\HasOne(name="primary_image", targetClass="\Bigcommerce\ORM\Entities\ProductImage", field="id", targetField="product_id", include=true, auto=true)
+ The product has one primary image, which is an object of class Bigcommerce\ORM\Entities\ProductImage
+ The mapping field is from Product.id to ProductImage.product_id
+ include=true: this resource will be loaded from included resources
+ auto=true: this resource will be loaded when retrieving the product

@BC\HasMany(name="images", targetClass="\Bigcommerce\ORM\Entities\ProductImage", field="id", targetField="product_id", include=true, auto=true)
+ The product has many images, each image is an object of class Bigcommerce\ORM\Entities\ProductImage

@BC\BelongToMany(name="categories", targetClass="\Bigcommerce\ORM\Entities\Category", field="categories", targetField="id", auto=true)
+ The product belongs to many categories, each category is an object of class Bigcommerce\ORM\Entities\Category

@BC\HasMany (name="reviews", targetClass="\Bigcommerce\ORM\Entities\ProductReview", field="id", targetField="product_id", auto=true)
+ The product has many reviews, each review is an object of class Bigcommerce\ORM\Entities\ProductReview

@see: [samples/Entities/MyProduct.php](./samples/Entities/MyProduct.php)