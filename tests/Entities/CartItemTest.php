<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\CartItem;
use Tests\BaseTestCase;

class CartItemTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\CartItem */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new CartItem();

        $this->entity
            ->setId(1)
            ->setCartId('someId');

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('someId', $this->entity->getCartId());
        $this->assertEquals(null, $this->entity->getLineItems());
        $this->assertEquals(null, $this->entity->getGiftCertificates());
        $this->assertEquals(null, $this->entity->getCustomItems());

        $item1 = new \Bigcommerce\ORM\Entities\LineItem();
        $item1
            ->setProductId(111)
            ->setQuantity(2);
        $item2 = new \Bigcommerce\ORM\Entities\LineItem();
        $item2
            ->setProductId(107)
            ->setQuantity(5);

        $gift = new \Bigcommerce\ORM\Entities\GiftCertificate();
        $gift
            ->setQuantity(1)
            ->setAmount(50)
            ->setName('Holiday Card')
            ->setTheme('Birthday')
            ->setMessage('Have a good holidays')
            ->setSender(['name' => 'Ken Ngo', 'email' => 'ken.ngo@bc.com'])
            ->setRecipient(['name' => 'Ken Ngo', 'email' => 'ken2.ngo@bc.com']);

        $custom = new \Bigcommerce\ORM\Entities\CustomItem();
        $custom
            ->setName('This is my item')
            ->setQuantity(1)
            ->setSku('sku')
            ->setListPrice(100);

        $this->entity
            ->addCustomItem($custom)
            ->addLineItem($item1)
            ->addLineItem($item2)
            ->addGiftCertificate($gift);

        $customItems = $this->entity->getCustomItems();
        $lineItems = $this->entity->getLineItems();
        $gifs = $this->entity->getGiftCertificates();

        $this->assertEquals(1, count($customItems));
        $this->assertEquals(2, count($lineItems));
        $this->assertEquals(1, count($gifs));
    }
}