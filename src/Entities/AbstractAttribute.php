<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class AbstractAttribute
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="AbstractAttribute")
 */
abstract class AbstractAttribute extends AbstractEntity
{
    /**
     * @var string|null
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var string|null
     * @BC\Field(name="type")
     */
    protected $type;

    /**
     * @var string|null
     * @BC\Field(name="date_created", readonly=true)
     */
    protected $dateCreated;

    /**
     * @var string|null
     * @BC\Field(name="date_modified", readonly=true)
     */
    protected $dateModified;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\AbstractAttribute
     */
    public function setName(?string $name): AbstractAttribute
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return \Bigcommerce\ORM\Entities\AbstractAttribute
     */
    public function setType(?string $type): AbstractAttribute
    {
        $this->type = $type;

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
     * @return \Bigcommerce\ORM\Entities\AbstractAttribute
     */
    public function setDateCreated(?string $dateCreated): AbstractAttribute
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
     * @return \Bigcommerce\ORM\Entities\AbstractAttribute
     */
    public function setDateModified(?string $dateModified): AbstractAttribute
    {
        $this->dateModified = $dateModified;

        return $this;
    }
}