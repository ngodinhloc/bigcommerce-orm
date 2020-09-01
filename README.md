# big-orm
big-orm allows users to work with Bigcommerce v3-rest-api (or v2-rest-api) just like working with an orm
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
<pre>
$config = [
            'store_url' => 'https://store.mybigcommerce.com',
            'username'	=> 'admin',
            'api_key'	=> 'd81aada4xc34xx3e18f0xxxx7f36ca'
          ];        
$entityManager = new \Bigcommerce\ORM\EntityManager($config);
</pre>

## Entities
#### Standard Entities
Standard entities contain standard public fields. These entities are predefined and shipped within big-orm.
- Bigcommerce\ORM\Entities\Customer
<pre>
namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class Customer
 * @package Bigcommerce\ORM\Entities
 * @BC\BigObject(name="Customer",path="/customers")
 */
class Customer extends Entity
{
    /**
     * @var string
     * @BC\Field(name="company")
     */
    protected $company;
    
    /**
     * @var string
     * @BC\Field(name="first_name")
     */
    protected $firstName;
    
    /**
     * @var string
     * @BC\Field(name="last_name")
     */
    protected $lastName;
    
    /**
     * @var string
     * @BC\Field(name="email")
     */
    protected $email;
    
    /**
     * @var string
     * @BC\Field(name="phone")
     */
    protected $phone;
    
    /**
     * @var \Bigcommerce\ORM\Entities\Order[]
     * @BC\OneToMany(
     *     name="Customer_Orders",
     *     targetClass="\Bigcommerce\ORM\Entities\Order"
     *     field="id",
     *     targetField="customer_id",
     *     lazy=true
     *     )
     */
    protected $orders = [];
}
</pre>
- Bigcommerce\ORM\Entities\Order
<pre>
namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class Order
 * @package Bigcommerce\ORM\Entities
 * @BC\BigObject(name="Order",path="/orders")
 */
class Order extends Entity
{
    /**
     * @var int
     * @BC\Field(name="customer_id", required=true)
     */
    protected $customerId;
    
    /**
     * @var string
     * @BC\Field(name="status")
     */
    protected $status;
    
    /**
     * @var float
     * @BC\Field(name="subtotal_inc_tax")
     */
    protected $subtotalIncTax;
    
    /**
     * @var string
     * @BC\Field(name="currency_code")
     */
    protected $currencyCode;
    
    /**
     * @var string
     * @BC\Field(name="date_created", readonly=true)
     * @BC\Date(format="Y-m-d")
     */
    protected $dateCreated;
    
    /**
     * @var \Bigcommerce\ORM\Entities\OrderProduct[]
     * @BC\OneToMany(
     *     name="Order_OrderProducts",
     *     targetClass="\Bigcommerce\ORM\Entities\OrderProduct"
     *     field="id",
     *     targetField="order_id",
     *     lazy=true
     *     )
     */
    protected $orderProducts = [];
}
</pre>
 + @BC\BigObject(name="Customer",path="/customers"): indicate that this class is mapping to Bigcommerce customer object
 + @BC\Field(name="company") : indicate that the property is mapping to filed 'company' in Bigcommerce customer object
 
### Customised Entities
If users add customised fields, which only they know of, 
then they can extend the standard entities to add their customised fields
- MyApp\Entities\CustomisedOrderProduct
<pre>
namespace MyApp\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entities\OrderProduct;

/**
 * Class CustomisedOrderProduct
 * @package MyApp\Entities
 * @BC\BigObject(name="OrderProduct",path="/order_products")
 */
class CustomisedOrderProduct extends OrderProduct
{

    /**
     * @var string
     * @BC\Field(name="my_customised_field")
     */
    protected $myCustomisedField;
}
</pre>

### Working with multiple stores
<pre>
$firstStoreConfig = [
            'store_url' => 'https://store.mybigcommerce.com',
            'username'	=> 'admin',
            'api_key'	=> 'd81aada4xc34xx3e18f0xxxx7f36ca'
          ];        
$firstStoreManager = new \Bigcommerce\ORM\EntityManager($firstStoreConfig);

$secondStoreConfig = [
            'store_url' => 'https://store.mybigcommerce.com',
            'username'	=> 'admin',
            'api_key'	=> 'd81aada4xc34xx3e18f0xxxx7f36ca'
          ];        
$secondStoreManager = new \Bigcommerce\ORM\EntityManager($secondStoreConfig);
$customer = new Customer();
$customer->setName('My Name');
$firstStoreManager->save($customer);
$secondStoreManage->save($customer)

</pre>
### Repositories
There are two ways to create repositories:
- Get the standard repository:
<pre>
/* @var \BigCommerce\ORM\Repository */
$customerRepository = $entityManager->getRepository(Customer::class);
</pre>
- Define a customised repository:
<pre>
use Bigcommerce\ORM\Repository

class MyCustomerRepository extends Repository
{
    protected $className = Customer::class;
    
    public function getCustomersByName(string $name = null){
    
    }
}

$myCustomerRepository = new MyCustomerRepository($entityManager);
</pre>

#### Create and Update Entities
<pre>
$customer = new Customer();
$customer->setName('Your Name');
$customerRepository->save($customer); // this will create a new Customer entity
$entityManager->save($customer); // do the same as using the customerRepository

$customer = $entityManager->getRepository(Customer::class)->find(100);
$customer->setName('New Name');
$customerRepository->save($customer); // this will update a the current Customer entity
$entityManager->save($customer); // do the same as using the customerRepository
</pre>

#### Validations and Relations
<pre>
 /**
     * @var int
     * @BC\Field(name="customer_id", required=true)
     */
    protected $customerId;
    
    /**
     * @var string
     * @BC\Field(name="date_created", readonly=true)
     * @BC\Date(format="Y-m-d")
     */
    protected $dateCreated;
    
    /**
     * @var \Bigcommerce\ORM\Entities\OrderProduct[]
     * @BC\OneToMany(
     *     name="Order_OrderProducts",
     *     targetClass="\Bigcommerce\ORM\Entities\OrderProduct",
     *     field="id",
     *     targetField="order_id",
     *     lazy=true
     *     )
     */
    protected $orderProducts = [];

</pre>

+ @BC\Field(name="customer_id", required=true): indicate that this field is required. An exception will be thrown if a value is not provided when saving the entity.
+ @BC\Field(name="date_created", readonly=true): indicate that this field readonly.
+ @BC\Date(format="Y-m-d"): indicate this field is a Date. An exception will be thrown if provided value is not the in required format.
+ @BC\OneToMany(name="Order_OrderProducts",targetClass="\Bigcommerce\ORM\Entities\OrderProduct",field="id",targetField="order_id",lazy=true): this Product has many OrderProduct
+ targetClass : the implemented class of OrderProduct
+ field: the field/column of Product entity
+ targetField: the field/column of the target ContOrderProduct entity
+ lazy: (default = true) if lazy = false, the repository will autoload the entities of the relation
<pre>
 $customer = $customerRepository->find(100);
 $orders = $customer->getOrders();  // return list of Order of this customer
 $firstOrder = $orders[0];
 $orderProducts = $firstOrder->getOrderProducts();  // return the list of OrderProduct of first order
</pre>

#### Find and Count
<pre>
// Find Customer by conditions, by default lazy loading = false (will load orders)
$customer = $customerRepository->findBy(['name = My Dev Store]);
// Find all Customer, by default lazy loading = true (will not load orders)
$customers = $customerRepository->findAll();
// Find total number of Customer
$count = $customerRepository->count();
</pre>

