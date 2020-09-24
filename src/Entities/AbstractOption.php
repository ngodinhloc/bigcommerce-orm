<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class AbstractOption
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="AbstractOption")
 */
abstract class AbstractOption extends AbstractEntity
{
    /**
     * @var string|null
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var string|null
     * @BC\Field(name="display_name")
     */
    protected $displayName;

    /**
     * @var string|null
     * @BC\Field(name="type")
     */
    protected $type;

    /**
     * @var int|null
     * @BC\Field(name="sort_order")
     */
    protected $sortOrder;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\AbstractOption
     */
    public function setName(?string $name): AbstractOption
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return \Bigcommerce\ORM\Entities\AbstractOption
     */
    public function setValue(?string $value): AbstractOption
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * @param string|null $displayName
     * @return \Bigcommerce\ORM\Entities\AbstractOption
     */
    public function setDisplayName(?string $displayName): AbstractOption
    {
        $this->displayName = $displayName;

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
     * @return \Bigcommerce\ORM\Entities\AbstractOption
     */
    public function setType(?string $type): AbstractOption
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    /**
     * @param int|null $sortOrder
     * @return \Bigcommerce\ORM\Entities\AbstractOption
     */
    public function setSortOrder(?int $sortOrder): AbstractOption
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }
}