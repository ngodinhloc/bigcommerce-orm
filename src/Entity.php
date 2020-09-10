<?php
declare(strict_types=1);

namespace Bigcommerce\ORM;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class Entity
 * @package Bigcommerce\ORM
 */
class Entity
{

    /**
     * @var string
     * @BC\Field(name="id", readonly=true)
     */
    protected $id;

    /**
     * @var bool
     */
    protected $isNew = false;

    /**
     * @var bool
     */
    protected $isPatched = false;

    /** @var \Bigcommerce\ORM\Metadata */
    protected $metadata;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return \Bigcommerce\ORM\Entity
     */
    public function setId(int $id = null)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return $this->isNew;
    }

    /**
     * @return bool|null
     */
    public function isPatched()
    {
        return $this->isPatched;
    }

    /**
     * @return \Bigcommerce\ORM\Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

}
