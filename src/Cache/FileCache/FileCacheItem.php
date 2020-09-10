<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Cache\FileCache;

use Psr\Cache\CacheItemInterface;

class FileCacheItem implements CacheItemInterface
{
    /** @var string */
    protected $key;

    /** @var mixed */
    protected $value;

    /** @var bool */
    protected $isHit = false;

    /** @var int */
    protected $hitCount = 0;

    /** @var \DateInterval|int seconds */
    protected $expiresAfter = 3600;

    /** @var \DateInterval|int */
    protected $cacheTime;

    /** @var \DateTime */
    protected $expiresAt;

    public function __construct(array $data = null)
    {
        $this->setData($data);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'key' => $this->getKey(),
            'hitCount' => $this->getHitCount(),
            'cacheTime' => $this->getCacheTime(),
            'expiresAt' => $this->getExpiresAt(),
            'expiresAfter' => $this->getExpiresAfter(),
            'value' => $this->get(),
        ];
    }

    /**
     * @param array|null $data
     */
    private function setData(array $data = null)
    {
        if (isset($data['key'])) {
            $this->setKey($data['key']);
        }

        if (isset($data['value'])) {
            $this->setValue($data['value']);
        }

        if (isset($data['hitCount'])) {
            $this->setHitCount($data['hitCount']);
        }

        $this->cacheTime = time();
        if (isset($data['cacheTime'])) {
            $this->setCacheTime($data['cacheTime']);
        }

        if (isset($data['expiresAfter'])) {
            $this->setExpiresAfter($data['expiresAfter']);
        }

        if (isset($data['expiresAt'])) {
            $this->setExpiresAt($data['expiresAt']);
        }
    }

    /**
     * @param string $key
     * @return $this
     */
    public function setKey(string $key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return mixed|string
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isNotExpired()
    {
        if ($this->expiresAt) {
            if ($this->expiresAt < date_create()) {
                return false;
            }

            if ($this->cacheTime + $this->expiresAfter < time()) {
                return false;
            }
        }

        if ($this->cacheTime + $this->expiresAfter < time()) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isHit()
    {
        return $this->isNotExpired() && $this->isHit;
    }

    /**
     * @param bool $isHit
     * @return \Bigcommerce\ORM\Cache\FileCache\FileCacheItem
     */
    public function setIsHit(bool $isHit): FileCacheItem
    {
        $this->isHit = $isHit;
        if ($isHit == true) {
            $this->hitCount++;
        }
        return $this;
    }

    /**
     * @param mixed $value
     * @return $this|\Bigcommerce\ORM\Cache\FileCache\FileCacheItem
     */
    public function set($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param \DateTimeInterface|null $expiration
     * @return \Bigcommerce\ORM\Cache\FileCache\FileCacheItem
     */
    public function expiresAt($expiration)
    {
        $this->expiresAt = $expiration;
        return $this;
    }

    /**
     * @param \DateInterval|int|null $time seconds
     * @return $this|\Bigcommerce\ORM\Cache\FileCache\FileCacheItem
     */
    public function expiresAfter($time)
    {
        $this->expiresAfter = $time;
        return $this;
    }

    /**
     * @return \DateInterval|int
     */
    public function getCacheTime()
    {
        return $this->cacheTime;
    }

    /**
     * @return \DateInterval|int
     */
    public function getExpiresAfter()
    {
        return $this->expiresAfter;
    }

    /**
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @return int
     */
    public function getHitCount()
    {
        return $this->hitCount;
    }

    /**
     * @param mixed $value
     * @return $this|\Bigcommerce\ORM\Cache\FileCache\FileCacheItem
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param int $hitCount
     * @return $this|\Bigcommerce\ORM\Cache\FileCache\FileCacheItem
     */
    public function setHitCount(int $hitCount)
    {
        $this->hitCount = $hitCount;
        return $this;
    }

    /**
     * @param \DateInterval|int $expiresAfter
     * @return $this|\Bigcommerce\ORM\Cache\FileCache\FileCacheItem
     */
    public function setExpiresAfter($expiresAfter)
    {
        $this->expiresAfter = $expiresAfter;
        return $this;
    }

    /**
     * @param \DateInterval|int $cacheTime
     * @return $this|\Bigcommerce\ORM\Cache\FileCache\FileCacheItem
     */
    public function setCacheTime($cacheTime)
    {
        $this->cacheTime = $cacheTime;
        return $this;
    }

    /**
     * @param \DateTime $expiresAt
     * @return $this|\Bigcommerce\ORM\Cache\FileCache\FileCacheItem
     */
    public function setExpiresAt(\DateTime $expiresAt)
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }

}
