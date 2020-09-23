<?php
declare(strict_types=1);

namespace Samples\Entities;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations as BC;

/**
 * Class MyProduct
 * @package Samples\Entities
 * @BC\Resource(name="Product", path="/catalog/products")
 */
class MyProduct extends AbstractEntity
{

    /**
     * @var string
     * @BC\Field(name="my_customised_field", customised=true, readonly=true)
     */
    protected $myCustomisedField;

    /**
     * @return string
     */
    public function getMyCustomisedField(): string
    {
        return $this->myCustomisedField;
    }

    /**
     * @param string $myCustomisedField
     * @return MyProduct
     */
    public function setMyCustomisedField(string $myCustomisedField): MyProduct
    {
        $this->myCustomisedField = $myCustomisedField;

        return $this;
    }

}