<?php
declare(strict_types=1);

namespace Tests\Cache\FileCache;

use Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException;
use Bigcommerce\ORM\Cache\FileCache\FileCachePool;
use Tests\BaseTestCase;

class FileCachePoolTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Cache\FileCache\FileCachePool */
    protected $cache;

    /**
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::__construct
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::getCacheDir
     * @covers \Bigcommerce\ORM\Cache\FileCache\FileCachePool::setCacheDir
     * @throws \Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException
     */
    public function testSettersAndGetters()
    {
        $cacheDir = 'invalidDir';
        $this->expectException(FileCachePoolException::class);
        $this->expectExceptionMessage(FileCachePoolException::MSG_INVALID_CACHE_DIR . $cacheDir);
        $this->cache = new FileCachePool($cacheDir);

        $cacheDir = __DIR__;
        $this->cache = new FileCachePool($cacheDir);
        $this->assertEquals($cacheDir, $this->cache->getCacheDir());

        $this->cache->setCacheDir($cacheDir);
        $this->assertEquals($cacheDir, $this->cache->getCacheDir());
    }
}