<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class Channel
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Channel", path="/channels", deletable=false)
 */
class Channel extends Entity
{
    /**
     * @var string
     * @BC\Field(name="type")
     */
    protected $type;

    /**
     * @var string
     * @BC\Field(name="platform")
     */
    protected $platform;

    /**
     * @var string
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var bool
     * @BC\Field(name="is_enabled")
     */
    protected $isEnabled = false;

    /**
     * @var mixed
     * @BC\Field(name="external_id")
     */
    protected $externalId;

    /**
     * @var string
     * @BC\Field(name="date_created")
     */
    protected $dateCreated;

    /**
     * @var string
     * @BC\Field(name="date_modified")
     */
    protected $dateModified;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return \Bigcommerce\ORM\Entities\Channel
     */
    public function setType(string $type = null): Channel
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param string|null $platform
     * @return \Bigcommerce\ORM\Entities\Channel
     */
    public function setPlatform(string $platform = null): Channel
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\Channel
     */
    public function setName(string $name = null): Channel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * @param bool $isEnabled
     * @return \Bigcommerce\ORM\Entities\Channel
     */
    public function setIsEnabled(bool $isEnabled = false): Channel
    {
        $this->isEnabled = $isEnabled;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param mixed|null $externalId
     * @return \Bigcommerce\ORM\Entities\Channel
     */
    public function setExternalId($externalId = null)
    {
        $this->externalId = $externalId;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param string|null $dateCreated
     * @return \Bigcommerce\ORM\Entities\Channel
     */
    public function setDateCreated(string $dateCreated = null): Channel
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * @param string|null $dateModified
     * @return \Bigcommerce\ORM\Entities\Channel
     */
    public function setDateModified(string $dateModified = null): Channel
    {
        $this->dateModified = $dateModified;
        return $this;
    }
}