<?php
declare(strict_types=1);

namespace Tests\Cache\FileCache;

use Bigcommerce\ORM\Cache\FileCache\FileCacheItem;
use Tests\BaseTestCase;

class FileCacheItemTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Cache\FileCache\FileCacheItem */
    protected $cacheItem;

    /**
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::__construct
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::setData
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::intervalToSeconds
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::isNotExpired
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::set
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::setIsHit
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::setExpiresAt
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::setKey
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::setExpiresAfter
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::setCacheTime
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::setHitCount
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::get
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::getExpiresAfter
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::getCacheTime
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::getExpiresAt
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::getKey
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::getHitCount
     */
    public function testSettersAndGetters()
    {
        $cacheTime = time();
        $data = [
            'key' => 'key',
            'hitCount' => 2,
            'cacheTime' => $cacheTime,
            'expiresAt' => new \DateTime('2020-09-12'),
            'expiresAfter' => 3600,
            'value' => 'value'
        ];
        $this->cacheItem = new FileCacheItem($data);
        $this->assertEquals($data['key'], $this->cacheItem->getKey());
        $this->assertEquals($data['hitCount'], $this->cacheItem->getHitCount());
        $this->assertEquals($data['expiresAt'], $this->cacheItem->getExpiresAt());
        $this->assertEquals($data['expiresAfter'], $this->cacheItem->getExpiresAfter());
        $this->assertEquals($data['value'], $this->cacheItem->get());
        $this->assertEquals($data['cacheTime'], $this->cacheItem->getCacheTime());

        $tomorrow = new \DateTime('2020-09-12');
        $this->cacheItem
            ->setIsHit(true)
            ->set('newValue')
            ->setHitCount(3)
            ->setCacheTime($cacheTime)
            ->setExpiresAfter(7200)
            ->setKey('newKey')
            ->setExpiresAt($tomorrow);

        $this->assertEquals(true, $this->cacheItem->isHit());
        $this->assertEquals('newValue', $this->cacheItem->get());
        $this->assertEquals(3, $this->cacheItem->getHitCount());
        $this->assertEquals($cacheTime, $this->cacheItem->getCacheTime());
        $this->assertEquals(7200, $this->cacheItem->getExpiresAfter());
        $this->assertEquals('newKey', $this->cacheItem->getKey());
        $this->assertEquals($tomorrow, $this->cacheItem->getExpiresAt());
    }

    /**
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::__construct
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::setData
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::toArray
     */
    public function testToArray()
    {
        $cacheTime = time();
        $data = [
            'key' => 'key',
            'hitCount' => 2,
            'cacheTime' => $cacheTime,
            'expiresAt' => new \DateTime('2020-09-12'),
            'expiresAfter' => 3600,
            'value' => 'value'
        ];
        $this->cacheItem = new FileCacheItem($data);
        $array = $this->cacheItem->toArray();
        $this->assertEquals($data, $array);
    }
}