<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Cache\FileCache;

use Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException;
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
     * @throws \Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException
     */
    public function __construct(string $cacheDir = null)
    {
        if (!is_dir($cacheDir)) {
            throw new FileCachePoolException(FileCachePoolException::MSG_INVALID_CACHE_DIR . $cacheDir);
        }
        $this->cacheDir = $cacheDir;
    }

    /**
     * @throws \Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException
     */
    public function __destruct()
    {
        $this->commit();
    }

    /**
     * @param string $key
     * @return \Psr\Cache\CacheItemInterface|null
     * @throws \Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException
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
     * @return bool
     * @throws \Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException
     */
    public function commit()
    {
        if (empty($this->itemPool)) {
            return true;
        }

        foreach ($this->itemPool as $hash => $item) {
            /** @var \Bigcommerce\ORM\Cache\FileCache\FileCacheItem $item */
            $file = $this->cacheDir . $hash;
            if ($item->isNotExpired()) {
                $data = $item->toArray();
                $json = json_encode($data);
                if (!$json) {
                    throw new FileCachePoolException(FileCachePoolException::ERROR_FAILED_ENCODE_DATA . $data);
                }

                try {
                    file_put_contents($file, $json);
                } catch (\Exception $exception) {
                    throw new FileCachePoolException(FileCachePoolException::ERROR_FAILED_TO_PUT_CONTENT . $exception->getMessage());
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
    private function hashKey(string $key = null)
    {
        return md5($key);
    }

    /**
     * Get cache in original data format
     *
     * @param string|null $hash
     * @return \Psr\Cache\CacheItemInterface|false
     * @throws \Bigcommerce\ORM\Cache\FileCache\Exceptions\FileCachePoolException
     */
    private function retrieve(string $hash)
    {
        $data = null;
        $file = $this->cacheDir . $hash;
        if (file_exists($file)) {
            try {
                $content = file_get_contents($file);
                if ($content) {
                    $data = json_decode($content, true);
                    return new FileCacheItem($data);
                }
            } catch (\Exception $exception) {
                throw new FileCachePoolException(FileCachePoolException::ERROR_FAILED_TO_GET_CONTENT . $exception->getMessage());
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

    public function getItems(array $keys = array())
    {
        // TODO: Implement getItems() method.
    }

    public function hasItem($key)
    {
        // TODO: Implement hasItem() method.
    }

    public function clear()
    {
        // TODO: Implement clear() method.
    }

    public function deleteItem($key)
    {
        // TODO: Implement deleteItem() method.
    }

    public function deleteItems(array $keys)
    {
        // TODO: Implement deleteItems() method.
    }

    public function saveDeferred(CacheItemInterface $item)
    {
        // TODO: Implement saveDeferred() method.
    }
}