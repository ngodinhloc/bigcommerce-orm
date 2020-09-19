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
     * @var string|null
     * @BC\Field(name="type")
     */
    protected $type;

    /**
     * @var string|null
     * @BC\Field(name="platform")
     */
    protected $platform;

    /**
     * @var string|null
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var bool|null
     * @BC\Field(name="is_enabled")
     */
    protected $isEnabled = false;

    /**
     * @var mixed|null
     * @BC\Field(name="external_id")
     */
    protected $externalId;

    /**
     * @var string|null
     * @BC\Field(name="date_created")
     */
    protected $dateCreated;

    /**
     * @var string|null
     * @BC\Field(name="date_modified")
     */
    protected $dateModified;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return \Bigcommerce\ORM\Entities\Channel
     */
    public function setType(?string $type): Channel
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    /**
     * @param string|null $platform
     * @return \Bigcommerce\ORM\Entities\Channel
     */
    public function setPlatform(?string $platform): Channel
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\Channel
     */
    public function setName(?string $name): Channel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    /**
     * @param bool|null $isEnabled
     * @return \Bigcommerce\ORM\Entities\Channel
     */
    public function setIsEnabled(?bool $isEnabled): Channel
    {
        $this->isEnabled = $isEnabled;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param mixed|null $externalId
     * @return \Bigcommerce\ORM\Entities\Channel
     */
    public function setExternalId($externalId): Channel
    {
        $this->externalId = $externalId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateCreated(): ?string
    {
        return $this->dateCreated;
    }

    /**
     * @param string|null $dateCreated
     * @return \Bigcommerce\ORM\Entities\Channel
     */
    public function setDateCreated(?string $dateCreated): Channel
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateModified(): ?string
    {
        return $this->dateModified;
    }

    /**
     * @param string|null $dateModified
     * @return \Bigcommerce\ORM\Entities\Channel
     */
    public function setDateModified(?string $dateModified): Channel
    {
        $this->dateModified = $dateModified;
        return $this;
    }
}