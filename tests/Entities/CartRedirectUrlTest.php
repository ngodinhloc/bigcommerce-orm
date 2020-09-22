<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CartRedirectUrl;
use Tests\BaseTestCase;

class CartRedirectUrlTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CartRedirectUrl */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new CartRedirectUrl();
        $this->entity
            ->setId(1)
            ->setCartId('123')
            ->setCartUrl('url')
            ->setCheckoutUrl('checkout')
            ->setEmbeddedCheckoutUrl('embedded');

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('123', $this->entity->getCartId());
        $this->assertEquals('url', $this->entity->getCartUrl());
        $this->assertEquals('checkout', $this->entity->getCheckoutUrl());
        $this->assertEquals('embedded', $this->entity->getEmbeddedCheckoutUrl());
    }
}