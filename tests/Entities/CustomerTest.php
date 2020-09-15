<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Customer;
use Tests\BaseTestCase;

class CustomerTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\Customer */
    protected $customer;

    public function testSettersAndGetters(){
        $this->customer = new Customer();
        $this->customer
            ->setId(1)
            ->setEmail('ken.ngo@bigcommerce.com')
            ->setDateCreated('2020-09-15')
            ->setPhone('0123456789')
            ->setCompany('BC')
            ->setLastName('Ngo')
            ->setFirstName('Ken')
            ->setDateModified('2020-09-15')
            ->setAddresses([]);

        $this->assertEquals(1, $this->customer->getId());
        $this->assertEquals('ken.ngo@bigcommerce.com', $this->customer->getEmail());
        $this->assertEquals('2020-09-15', $this->customer->getDateCreated());
        $this->assertEquals('0123456789', $this->customer->getPhone());
        $this->assertEquals('BC', $this->customer->getCompany());
        $this->assertEquals('Ngo', $this->customer->getLastName());
        $this->assertEquals('Ken', $this->customer->getFirstName());
        $this->assertEquals('2020-09-15', $this->customer->getDateModified());
        $this->assertEquals([], $this->customer->getAddresses());
    }
}