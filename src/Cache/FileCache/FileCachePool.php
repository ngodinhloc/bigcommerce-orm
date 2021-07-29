<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Cache\FileCache;

use Bigcommerce\ORM\Exceptions\FileCachePoolException;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

class FileCachePool implements CacheItemPoolInterface
{
    /** @var string|null */
    protected $cacheDir;

    /** @var \Psr\Cache\CacheItemInterface[] */
    protected $itemPool;

    /**
     * FileCachePool constructor.
     * @param string|null $cacheDir
     * @throws \Bigcommerce\ORM\Exceptions\FileCachePoolException
     */
    public function __construct(?string $cacheDir = null)
    {
        if (!is_dir($cacheDir)) {
            throw new FileCachePoolException(FileCachePoolException::ERROR_INVALID_CACHE_DIR . $cacheDir);
        }
        $this->cacheDir = $cacheDir;
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\FileCachePoolException
     */
    public function __destruct()
    {
        $this->commit();
    }

    /**
     * @param \Psr\Cache\CacheItemInterface $item
     * @return $this|bool
     */
    public function save(CacheItemInterface $item)
    {
        $hash = $this->hashKey($item->getKey());
        $this->itemPool[$hash] = $item;

        return $this;
    }

    /**
     * @param string $key
     * @return \Psr\Cache\CacheItemInterface|null
     * @throws \Bigcommerce\ORM\Exceptions\FileCachePoolException
     */
    public function getItem($key)
    {
        $hash = $this->hashKey($key);
        if (isset($this->itemPool[$hash])) {
            /** @var \Bigcommerce\ORM\Cache\FileCache\FileCacheItem $item */
            $item = $this->itemPool[$hash];
            $item->setIsHit(true);
            $this->itemPool[$hash] = $item;

            return $item;
        }

        if ($item = $this->retrieve($hash)) {
            $item->setIsHit(true);
            $this->itemPool[$hash] = $item;

            return $item;
        }

        return new FileCacheItem();
    }

    /**
     * @param array $keys
     * @return array|\Traversable
     * @throws \Bigcommerce\ORM\Exceptions\FileCachePoolException
     */
    public function getItems(array $keys = array())
    {
        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->getItem($key);
        }

        return $items;
    }

    /**
     * @return bool
     * @throws \Bigcommerce\ORM\Exceptions\FileCachePoolException
     */
    public function commit()
    {
        if (empty($this->itemPool)) {
            return true;
        }

        foreach ($this->itemPool as $hash => $item) {
            /** @var \Bigcommerce\ORM\Cache\FileCache\FileCacheItem $item */
            $file = $this->cacheDir . DIRECTORY_SEPARATOR . $hash;
            if ($item->isNotExpired()) {
                $data = $item->toArray();
                $json = json_encode($data);
                if ($json === false) {
                    throw new FileCachePoolException(FileCachePoolException::ERROR_FAILED_ENCODE_DATA . $data);
                }

                if(file_put_contents($file, $json) === false){
                    throw new FileCachePoolException(FileCachePoolException::ERROR_FAILED_TO_PUT_CONTENT);
                }
            } else {
                if (file_exists($file)) {
                    @unlink($file);
                }
            }
        }

        return true;
    }

    /**
     * Create cache key
     *
     * @param string|null $key
     * @return string
     */
    public function hashKey(string $key = null)
    {
        return md5($key);
    }

    /**
     * Get cache in original data format
     *
     * @param string|null $hash
     * @return \Psr\Cache\CacheItemInterface|false
     */
    private function retrieve(string $hash)
    {
        $data = null;
        $file = $this->cacheDir . DIRECTORY_SEPARATOR . $hash;
        if (file_exists($file)) {
            $content = file_get_contents($file);
            if ($content !== false) {
                $data = json_decode($content, true);
                if($data !== null) {
                    return new FileCacheItem($data);
                }
            }
        }

        return false;
    }

    /**
     * @return string|null
     */
    public function getCacheDir()
    {
        return $this->cacheDir;
    }

    /**
     * @param string|null $cacheDir
     * @return \Bigcommerce\ORM\Cache\FileCache\FileCachePool
     */
    public function setCacheDir(string $cacheDir): FileCachePool
    {
        $this->cacheDir = $cacheDir;

        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasItem($key)
    {
        $hash = $this->hashKey($key);

        return isset($this->itemPool[$hash]);
    }

    /**
     * @return bool|void
     */
    public function clear()
    {
        $this->itemPool = null;
    }

    /**
     * @param string $key
     * @return bool|void
     */
    public function deleteItem($key)
    {
        $hash = $this->hashKey($key);
        if (isset($this->itemPool[$hash])) {
            unset($this->itemPool[$hash]);
        }
    }

    /**
     * @param array $keys
     * @return bool|void
     */
    public function deleteItems(array $keys)
    {
        foreach ($keys as $key) {
            $this->deleteItem($key);
        }
    }

    /**
     * @param \Psr\Cache\CacheItemInterface $item
     * @return bool|void
     */
    public function saveDeferred(CacheItemInterface $item)
    {
        return $this->save($item);
    }

    /**
     * @return \Psr\Cache\CacheItemInterface[]
     */
    public function getItemPool()
    {
        return $this->itemPool;
    }

    /**
     * @param \Psr\Cache\CacheItemInterface[] $itemPool
     * @return \Bigcommerce\ORM\Cache\FileCache\FileCachePool
     */
    public function setItemPool(array $itemPool): FileCachePool
    {
        $this->itemPool = $itemPool;

        return $this;
    }

}
