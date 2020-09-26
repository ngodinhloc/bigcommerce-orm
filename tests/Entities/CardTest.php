<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Card;
use Tests\BaseTestCase;

class CardTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\Card */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new Card();
        $this->entity
            ->setId(1)
            ->setVerificationValue('123')
            ->setExpiryYear(2021)
            ->setExpiryMonth(2)
            ->setNumber('1234')
            ->setCardholderName('Ken')
            ->setIssueNumber('4321')
            ->setType('visa')
            ->setIssueMonth(6)
            ->setIssueYear(2020);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('123', $this->entity->getVerificationValue());
        $this->assertEquals(2021, $this->entity->getExpiryYear());
        $this->assertEquals(2, $this->entity->getExpiryMonth());
        $this->assertEquals('1234', $this->entity->getNumber());
        $this->assertEquals('Ken', $this->entity->getCardholderName());
        $this->assertEquals('4321', $this->entity->getIssueNumber());
        $this->assertEquals('visa', $this->entity->getType());
        $this->assertEquals(6, $this->entity->getIssueMonth());
        $this->assertEquals(2020, $this->entity->getIssueYear());
    }
}