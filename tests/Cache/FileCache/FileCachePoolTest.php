<?php
declare(strict_types=1);

namespace Tests\Cache\FileCache;

use Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException;
use Bigcommerce\ORM\Cache\FileCache\FileCacheItem;
use Bigcommerce\ORM\Cache\FileCache\FileCachePool;
use Tests\BaseTestCase;

class FileCachePoolTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Cache\FileCache\FileCachePool */
    protected $cache;

    /** @var \Bigcommerce\ORM\Cache\FileCache\FileCacheItem[] */
    protected $items;

    protected function setUp(): void
    {
        parent::setUp();
        $cacheTime = time();
        $tomorrow = new \DateTime('tomorrow');
        $data1 = [
            'key' => 'key1',
            'hitCount' => 2,
            'cacheTime' => $cacheTime,
            'expiresAt' => $tomorrow,
            'expiresAfter' => 3600,
            'value' => 'value'
        ];
        $data2 = [
            'key' => 'key2',
            'hitCount' => 2,
            'cacheTime' => $cacheTime,
            'expiresAt' => $tomorrow,
            'expiresAfter' => 3600,
            'value' => 'value'
        ];
        $item1 = new FileCacheItem($data1);
        $item2 = new FileCacheItem($data2);
        $this->items = [$item1, $item2];
        $cacheDir = dirname(dirname(__DIR__)) . '/assets/caches';
        $this->cache = new FileCachePool($cacheDir);
    }

    /**
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::__construct
     * @throws \Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException
     */
    public function testConstruct()
    {
        $cacheDir = 'invalidDir';
        $this->expectException(FileCachePoolException::class);
        $this->expectExceptionMessage(FileCachePoolException::MSG_INVALID_CACHE_DIR . $cacheDir);
        $this->cache = new FileCachePool($cacheDir);
    }

    /**
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::__construct
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::setCacheDir
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::getCacheDir
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::setItemPool
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::getItemPool
     * @throws \Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException
     */
    public function testSettersAndGetters()
    {
        $cacheDir = __DIR__;
        $this->cache = new FileCachePool($cacheDir);
        $this->assertEquals($cacheDir, $this->cache->getCacheDir());

        $cacheDir = __DIR__.'/caches';
        $this->cache->setCacheDir($cacheDir);
        $this->assertEquals($cacheDir, $this->cache->getCacheDir());

        $this->cache->setItemPool($this->items);
        $this->assertEquals($this->items, $this->cache->getItemPool());
        $this->cache->clear();
    }

    /**
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::hashKey
     */
    public function testHashKey()
    {
        $key = 'key1';
        $hash = $this->cache->hashKey($key);
        $this->assertEquals(md5($key), $hash);
    }

    /**
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::save
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::hasItem
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::getItem
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::deleteItem
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::getItemPool
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::saveDeferred
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::clear
     * @throws \Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException
     */
    public function testSave()
    {
        $cacheTime = time();
        $tomorrow = new \DateTime('tomorrow');
        $data3 = [
            'key' => 'key3',
            'hitCount' => 2,
            'cacheTime' => $cacheTime,
            'expiresAt' => $tomorrow,
            'expiresAfter' => 3600,
            'value' => 'value'
        ];
        $item3 = new FileCacheItem($data3);
        $this->cache->save($item3);
        $this->assertTrue($this->cache->hasItem('key3'));
        $get = $this->cache->getItem('key3');
        $this->assertEquals($item3, $get);
        $this->cache->deleteItem('key3');
        $this->assertEquals([], $this->cache->getItemPool());
        $this->cache->saveDeferred($item3);
        $get = $this->cache->getItem('key3');
        $this->assertEquals($item3, $get);
        $this->cache->clear();
    }

    /**
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::save
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::getItems
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::deleteItems
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::getItemPool
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::clear
     * @throws \Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException
     */
    public function testGetItems()
    {
        $items = [];
        foreach ($this->items as $item) {
            $this->cache->save($item);
            $items[$item->getKey()] = $item;
        }
        $getItems = $this->cache->getItems(['key1', 'key2']);
        $this->assertEquals($items, $getItems);

        $this->cache->deleteItems(['key1', 'key2']);
        $this->assertEquals([], $this->cache->getItemPool());
        $this->cache->clear();
    }

    /**
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::getItem
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::retrieve
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::clear
     * @throws \Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException
     */
    public function testRetrieve()
    {
        $item4 = $this->cache->getItem('key4');
        $this->assertEquals(null, $item4->getKey());

        $item = $this->cache->getItem('key1');
        $this->assertEquals('key1', $item->getKey());
        $this->cache->clear();
    }

    /**
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::setItemPool
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::save
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::getCacheDir
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::commit
     * @throws \Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException
     */
    public function testCommit()
    {
        $this->cache->setItemPool([]);
        $commit = $this->cache->commit();
        $this->assertEquals(true, $commit);

        foreach ($this->items as $item) {
            $this->cache->save($item);
        }
        $file1 = $this->cache->getCacheDir() . DIRECTORY_SEPARATOR . md5('key1');
        $file2 = $this->cache->getCacheDir() . DIRECTORY_SEPARATOR . md5('key2');
        unset($this->cache);

        $this->assertFileExists($file1);
        $this->assertFileExists($file2);
    }
}