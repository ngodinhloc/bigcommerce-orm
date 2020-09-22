<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CartGiftCertificate;
use Tests\BaseTestCase;

class CartGiftCertificateTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CartGiftCertificate */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new CartGiftCertificate();
        $this->entity
            ->setQuantity(2)
            ->setId(1)
            ->setName('name')
            ->setTheme('theme')
            ->setRecipient([])
            ->setSender([])
            ->setMessage('message')
            ->setAmount(100);

        $this->assertEquals(2, $this->entity->getQuantity());
        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('name', $this->entity->getName());
        $this->assertEquals('theme', $this->entity->getTheme());
        $this->assertEquals([], $this->entity->getRecipient());
        $this->assertEquals([], $this->entity->getSender());
        $this->assertEquals('message', $this->entity->getMessage());
        $this->assertEquals(100, $this->entity->getAmount());
    }
}