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

    /** @var int seconds */
    protected $expiresAfter = 3600;

    /** @var int */
    protected $cachesAt;

    /** @var int */
    protected $expiresAt;

    /**
     * FileCacheItem constructor.
     * @param array|null $data
     */
    public function __construct(?array $data = null)
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
            'cacheTime' => $this->getCachesAt(),
            'expiresAt' => $this->getExpiresAt(),
            'expiresAfter' => $this->getExpiresAfter(),
            'value' => $this->get(),
        ];
    }

    /**
     * @param array|null $data
     */
    private function setData(?array $data)
    {
        if (isset($data['key'])) {
            $this->setKey($data['key']);
        }

        if (isset($data['hitCount'])) {
            $this->setHitCount($data['hitCount']);
        }

        $this->cachesAt = time();
        if (isset($data['cacheTime'])) {
            $this->cachesAt($data['cacheTime']);
        }

        if (isset($data['expiresAfter'])) {
            $this->expiresAfter($data['expiresAfter']);
        }

        if (isset($data['expiresAt'])) {
            $this->expiresAt($data['expiresAt']);
        }

        if (isset($data['value'])) {
            $this->set($data['value']);
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
     * @param mixed $value
     * @return $this|\Bigcommerce\ORM\Cache\FileCache\FileCacheItem
     */
    public function set($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed|string
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * @param \DateTimeInterface|int $cacheAt
     * @return $this|\Bigcommerce\ORM\Cache\FileCache\FileCacheItem
     */
    public function cachesAt($cacheAt)
    {
        if ($cacheAt instanceof \DateTime) {
            $cacheAt = $cacheAt->getTimestamp();
        }
        if (is_int($cacheAt)) {
            $this->cachesAt = $cacheAt;
        }

        return $this;
    }

    /**
     * @return \DateTime|int
     */
    public function getCachesAt()
    {
        return $this->cachesAt;
    }

    /**
     * @param \DateTimeInterface|null $expiration
     * @return \Bigcommerce\ORM\Cache\FileCache\FileCacheItem
     */
    public function expiresAt($expiration = null)
    {
        if ($expiration instanceof \DateTime) {
            $expiration = $expiration->getTimestamp();
        }
        if (is_int($expiration) || is_null($expiration)) {
            $this->expiresAt = $expiration;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param \DateInterval|int|null $time seconds
     * @return $this|\Bigcommerce\ORM\Cache\FileCache\FileCacheItem
     */
    public function expiresAfter($time)
    {
        if ($time instanceof \DateInterval) {
            $time = $this->intervalToSeconds($time);
        }
        if (is_int($time)) {
            $this->expiresAfter = $time;
        }

        return $this;
    }

    /**
     * @return \DateInterval|int
     */
    public function getExpiresAfter()
    {
        return $this->expiresAfter;
    }

    /**
     * @return bool
     */
    public function isNotExpired()
    {
        $now = time();
        if ($this->expiresAt) {
            if ($this->expiresAt < $now) {
                return false;
            }

            if (($this->cachesAt + $this->expiresAfter) < $now) {
                return false;
            }
        }

        if (($this->cachesAt + $this->expiresAfter) < $now) {
            return false;
        }

        return true;
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
     * @return bool
     */
    public function isHit()
    {
        return $this->isNotExpired() && $this->isHit;
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
     * @return int
     */
    public function getHitCount()
    {
        return $this->hitCount;
    }

    /**
     * @param \DateInterval $interval
     * @return float|int
     */
    private function intervalToSeconds(\DateInterval $interval)
    {
        return $interval->days * 86400 + $interval->h * 3600
            + $interval->i * 60 + $interval->s;
    }

}
