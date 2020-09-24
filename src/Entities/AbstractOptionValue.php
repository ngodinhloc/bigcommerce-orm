<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class AbstractOptionValue
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="AbstractOptionValue")
 */
abstract class AbstractOptionValue extends AbstractEntity
{
    /**
     * @var string|null
     * @BC\Field(name="label")
     */
    protected $label;

    /**
     * @var int|null
     * @BC\Field(name="sort_order")
     */
    protected $sortOrder;

    /**
     * @var mixed|null
     * @BC\Field(name="value_date")
     */
    protected $valueData;

    /**
     * @var bool|null
     * @BC\Field(name="is_default")
     */
    protected $isDefault = false;

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     * @return \Bigcommerce\ORM\Entities\AbstractOptionValue
     */
    public function setLabel(?string $label): AbstractOptionValue
    {
        $this->label = $label;

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
     * @return \Bigcommerce\ORM\Entities\AbstractOptionValue
     */
    public function setSortOrder(?int $sortOrder): AbstractOptionValue
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getValueData()
    {
        return $this->valueData;
    }

    /**
     * @param mixed|null $valueData
     * @return \Bigcommerce\ORM\Entities\AbstractOptionValue
     */
    public function setValueData($valueData): AbstractOptionValue
    {
        $this->valueData = $valueData;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isDefault(): ?bool
    {
        return $this->isDefault;
    }

    /**
     * @param bool|null $isDefault
     * @return \Bigcommerce\ORM\Entities\AbstractOptionValue
     */
    public function setIsDefault(?bool $isDefault): AbstractOptionValue
    {
        $this->isDefault = $isDefault;

        return $this;
    }
}