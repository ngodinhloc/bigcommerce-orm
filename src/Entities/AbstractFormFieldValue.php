<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class AbstractFormFieldValue
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="AbstractFormFieldValue")
 */
abstract class AbstractFormFieldValue extends AbstractEntity
{
    /**
     * @var string|null
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var mixed|null
     * @BC\Field(name="value")
     */
    protected $value;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\AbstractFormFieldValue
     */
    public function setName(?string $name): AbstractFormFieldValue
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed|null $value
     * @return \Bigcommerce\ORM\Entities\AbstractFormFieldValue
     */
    public function setValue($value): AbstractFormFieldValue
    {
        $this->value = $value;

        return $this;
    }
}