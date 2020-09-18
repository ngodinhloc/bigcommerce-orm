<?php
require_once('./vendor/autoload.php');

$authCredentials = include('_auth.php');
$options = include('_options.php');

try {
    $config = new \Bigcommerce\ORM\Configuration($authCredentials, $options);
    $entityManager = $config->configEntityManager();

    /** get all customers */
    $allCustomers = $entityManager->findAll(\Bigcommerce\ORM\Entities\Customer::class);
    echo count($allCustomers) . PHP_EOL;

    /** get some customers by queries */
    $queryBuilder = new \Bigcommerce\ORM\QueryBuilder();
    $queryBuilder
        ->whereIn('id', [1, 2])
//    ->whereEqual('id', 1) : customer does not allow to filter  id =
        ->whereLike('name', 'Ken')
        ->page(1)->limit(50)
        ->orderBy('date_created', 'desc')
        ->order(['last_name' => 'asc']);
    $someCustomers = $entityManager->findBy(\Bigcommerce\ORM\Entities\Customer::class, null, $queryBuilder);
    echo count($someCustomers);

    /** batch update customers */
    /** @var \Bigcommerce\ORM\Entities\Customer $customer1 */
    $customer1 = $someCustomers[0];
    /** @var \Bigcommerce\ORM\Entities\Customer $customer2 */
    $customer2 = $someCustomers[1];
    $customer1->setFirstName('Ken1')->setCompany('BC1');
    $customer2->setFirstName('Ken2')->setCompany('BC2');
    $updatedCustomers = $entityManager->batchUpdate([$customer1,$customer2]);
    echo count($updatedCustomers);

    /**
     * you can't get customer by id . Please use findBy
     * you can't create one customer. Please use batchCreate
     */

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
    echo count($newCustomers);

    /** delete customers */
    $deleted = $entityManager->delete(\Bigcommerce\ORM\Entities\Customer::class, null, [10,11]);
    echo $deleted;

} catch (\Exception $e) {
    echo $e->getMessage();
}
