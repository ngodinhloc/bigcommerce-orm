<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Card;
use Bigcommerce\ORM\Entities\Payment;
use Bigcommerce\ORM\Entities\PaymentMethod;
use Bigcommerce\ORM\Mapper\EntityMapper;
use Tests\BaseTestCase;

use function Webmozart\Assert\Tests\StaticAnalysis\null;

class PaymentTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\Payment */
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
            ->setPaymentData([])
            ->setPaymentAccessToken(null);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('USD', $this->entity->getCurrencyCode());
        $this->assertEquals(100, $this->entity->getAmount());
        $this->assertEquals(123, $this->entity->getOrderId());
        $this->assertEquals([], $this->entity->getPaymentData());
        $this->assertEquals(null, $this->entity->getPaymentAccessToken());

        $mapper = new EntityMapper();
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
