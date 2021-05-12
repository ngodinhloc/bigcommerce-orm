<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Customer;
use Tests\BaseTestCase;

class CustomerTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\Customer */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new Customer();
        $this->entity
            ->setId(1)
            ->setEmail('ken.ngo@bigcommerce.com')
            ->setDateCreated('2020-09-15')
            ->setPhone('0123456789')
            ->setCompany('BC')
            ->setLastName('Ngo')
            ->setFirstName('Ken')
            ->setDateModified('2020-09-15')
            ->setAddresses([]);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('ken.ngo@bigcommerce.com', $this->entity->getEmail());
        $this->assertEquals('2020-09-15', $this->entity->getDateCreated());
        $this->assertEquals('0123456789', $this->entity->getPhone());
        $this->assertEquals('BC', $this->entity->getCompany());
        $this->assertEquals('Ngo', $this->entity->getLastName());
        $this->assertEquals('Ken', $this->entity->getFirstName());
        $this->assertEquals('2020-09-15', $this->entity->getDateModified());
        $this->assertEquals([], $this->entity->getAddresses());
    }
}
