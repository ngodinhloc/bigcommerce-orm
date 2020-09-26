<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Card;
use Bigcommerce\ORM\Entities\Payment;
use Bigcommerce\ORM\Entities\PaymentMethod;
use Bigcommerce\ORM\Mapper;
use Tests\BaseTestCase;

class PaymentTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\Payment */
    protected $entity;

    /**
     * testSettersAndGetters
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testSettersAndGetters()
    {
        $this->entity = new Payment();
        $this->entity
            ->setId(1)
            ->setCurrencyCode('USD')
            ->setAmount(100)
            ->setOrderId(123)
            ->setPaymentData([]);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('USD', $this->entity->getCurrencyCode());
        $this->assertEquals(100, $this->entity->getAmount());
        $this->assertEquals(123, $this->entity->getOrderId());
        $this->assertEquals([], $this->entity->getPaymentData());

        $mapper = new Mapper();
        $card = new Card();
        $paymentMethod = new PaymentMethod();

        $this->entity
            ->setMapper($mapper)
            ->setPaymentMethod($paymentMethod)
            ->setPaymentInstrument($card);

        $this->assertEquals($mapper, $this->entity->getMapper());
        $this->assertEquals($paymentMethod, $this->entity->getPaymentMethod());
        $this->assertEquals($card, $this->entity->getPaymentInstrument());
    }
}