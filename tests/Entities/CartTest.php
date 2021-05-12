<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Cart;
use Bigcommerce\ORM\Mapper;
use Tests\BaseTestCase;

class CartTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\Cart */
    protected $entity;

    /**
     * testSettersAndGetters
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testSettersAndGetters()
    {
        $mapper = new Mapper();
        $this->entity = new Cart();
        $this->entity
            ->setId(1)
            ->setCustomerId(2)
            ->setEmail('kn@bc.com')
            ->setParentId(null)
            ->setChannelId(1)
            ->setCurrency(['USD'])
            ->setCreatedTime('2020-09-16')
            ->setUpdatedTime('2020-09-17')
            ->setLineItems([]);

        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals(2, $this->entity->getCustomerId());
        $this->assertEquals('kn@bc.com', $this->entity->getEmail());
        $this->assertEquals(null, $this->entity->getParentId());
        $this->assertEquals(1, $this->entity->getChannelId());
        $this->assertEquals(['USD'], $this->entity->getCurrency());
        $this->assertEquals('2020-09-16', $this->entity->getCreatedTime());
        $this->assertEquals('2020-09-17', $this->entity->getUpdatedTime());
        $this->assertEquals(null, $this->entity->getCoupons());
        $this->assertEquals([], $this->entity->getLineItems());
        $this->assertEquals(null, $this->entity->isTaxIncluded());
        $this->assertEquals(null, $this->entity->getBaseAmount());
        $this->assertEquals(null, $this->entity->getDiscountAmount());
        $this->assertEquals(null, $this->entity->getCartAmount());
        $this->assertEquals(null, $this->entity->getDiscounts());
        $this->assertEquals(null, $this->entity->getCustomItems());
        $this->assertEquals(null, $this->entity->getGiftCertificates());
        $this->assertEquals(null, $this->entity->getDigitalItems());
        $this->assertEquals(null, $this->entity->getPhysicalItems());
        $this->assertEquals(null, $this->entity->getRedirectUrl());

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
            ->addLineItem($item1)
            ->addLineItem($item2)
            ->addGiftCertificate($gift)
            ->addCustomItem($custom);

        $lines = [
            'physical_items' => [
                $mapper->toArray($item1)
            ],
            'digital_items' => [
                $mapper->toArray($item2)
            ],
            'custom_items' => [
                $mapper->toArray($custom)
            ],
            'gift_certificates' => [
                $mapper->toArray($gift)
            ],
        ];

        $this->entity->setLineItems($lines);
        $physicalItems = $this->entity->getPhysicalItems();
        $digitalItems = $this->entity->getDigitalItems();
        $customItems = $this->entity->getCustomItems();
        $gifs = $this->entity->getGiftCertificates();

        $this->assertEquals($lines, $this->entity->getLineItems());
        $this->assertEquals(1, count($physicalItems));
        $this->assertEquals(1, count($digitalItems));
        $this->assertEquals(1, count($customItems));
        $this->assertEquals(1, count($gifs));
    }
}
