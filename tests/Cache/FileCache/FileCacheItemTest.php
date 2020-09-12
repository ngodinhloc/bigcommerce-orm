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
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::expiresAt
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::setKey
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::expiresAfter
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::cachesAt
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::setHitCount
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::get
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::getExpiresAfter
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::getCachesAt
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::getExpiresAt
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::getKey
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::getHitCount
     */
    public function testSettersAndGetters()
    {
        $cacheTime = time();
        $tomorrow = new \DateTime('tomorrow');
        $data = [
            'key' => 'key',
            'hitCount' => 2,
            'cacheTime' => $cacheTime,
            'expiresAt' => $tomorrow,
            'expiresAfter' => 3600,
            'value' => 'value'
        ];
        $this->cacheItem = new FileCacheItem($data);
        $this->assertEquals($data['key'], $this->cacheItem->getKey());
        $this->assertEquals($data['hitCount'], $this->cacheItem->getHitCount());
        $this->assertEquals($tomorrow->getTimestamp(), $this->cacheItem->getExpiresAt());
        $this->assertEquals($data['expiresAfter'], $this->cacheItem->getExpiresAfter());
        $this->assertEquals($data['value'], $this->cacheItem->get());
        $this->assertEquals($data['cacheTime'], $this->cacheItem->getCachesAt());

        $tomorrow = new \DateTime('tomorrow');
        $this->cacheItem
            ->setIsHit(true)
            ->set('newValue')
            ->setHitCount(3)
            ->cachesAt($cacheTime)
            ->expiresAfter(7200)
            ->setKey('newKey')
            ->expiresAt($tomorrow);

        $this->assertEquals(true, $this->cacheItem->isHit());
        $this->assertEquals('newValue', $this->cacheItem->get());
        $this->assertEquals(3, $this->cacheItem->getHitCount());
        $this->assertEquals($cacheTime, $this->cacheItem->getCachesAt());
        $this->assertEquals(7200, $this->cacheItem->getExpiresAfter());
        $this->assertEquals('newKey', $this->cacheItem->getKey());
        $this->assertEquals($tomorrow->getTimestamp(), $this->cacheItem->getExpiresAt());

        $yesterday = new \DateTime('yesterday');
        $oneHour = new \DateInterval('PT1H');
        $this->cacheItem->expiresAt($yesterday);
        $this->assertEquals(false, $this->cacheItem->isNotExpired());
        $this->assertEquals(false, $this->cacheItem->isHit());

        $expiredAt = new \DateTime(date("Y-m-d", strtotime("+2 day")));
        $this->cacheItem
            ->cachesAt($yesterday)
            ->expiresAfter($oneHour)
            ->expiresAt($expiredAt);
        $this->assertEquals(false, $this->cacheItem->isNotExpired());

        $this->cacheItem->expiresAt(null);
        $this->assertEquals(false, $this->cacheItem->isNotExpired());
    }

    /**
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::__construct
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::setData
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCacheItem::toArray
     */
    public function testToArray()
    {
        $cacheTime = time();
        $now = new \DateTime('now');
        $data = [
            'key' => 'key',
            'hitCount' => 2,
            'cacheTime' => $cacheTime,
            'expiresAt' => $now,
            'expiresAfter' => 3600,
            'value' => 'value'
        ];
        $expected = [
            'key' => 'key',
            'hitCount' => 2,
            'cacheTime' => $cacheTime,
            'expiresAt' => $now->getTimestamp(),
            'expiresAfter' => 3600,
            'value' => 'value'
        ];
        $this->cacheItem = new FileCacheItem($data);
        $array = $this->cacheItem->toArray();
        $this->assertEquals($expected, $array);
    }
}