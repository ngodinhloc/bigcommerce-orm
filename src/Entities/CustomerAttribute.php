<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class CustomerAttribute
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="CustomerAttribute",path="/customers/attributes")
 */
class CustomerAttribute extends Entity
{
    /**
     * @var string
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var string
     * @BC\Field(name="type")
     */
    protected $type;

    /**
     * @var string
     * @BC\Field(name="date_created", readonly=true)
     */
    protected $dateCreated;

    /**
     * @var string
     * @BC\Field(name="date_modified", readonly=true)
     */
    protected $dateModified;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\CustomerAttribute
     */
    public function setName(string $name = null): CustomerAttribute
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return \Bigcommerce\ORM\Entities\CustomerAttribute
     */
    public function setType(string $type = null): CustomerAttribute
    {
        $this->type = $type;
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
     * @return \Bigcommerce\ORM\Entities\CustomerAttribute
     */
    public function setDateCreated(string $dateCreated = null): CustomerAttribute
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
     * @return \Bigcommerce\ORM\Entities\CustomerAttribute
     */
    public function setDateModified(string $dateModified = null): CustomerAttribute
    {
        $this->dateModified = $dateModified;
        return $this;
    }
}