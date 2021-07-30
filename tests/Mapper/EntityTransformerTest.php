<?php

namespace Tests\Mapper;

use Bigcommerce\ORM\Entities\ProductModifier;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\Mapper\EntityTransformer;
use PHPUnit\Framework\TestCase;

class EntityTransformerTest extends TestCase
{
    /** @coversDefaultClass  \Bigcommerce\ORM\Mapper\EntityTransformer */
    private $transformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformer = new EntityTransformer();
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testToArray()
    {
        $modifier = new ProductModifier();
        $modifier
            ->setName('Name')
            ->setType('file')
            ->setDisplayName('Display Name');
        $expected = [
            'product_id' => null,
            'name' => 'Name',
            'display_name' => 'Display Name',
            'type' => 'file',
            'required' => false,
            'sort_order' => null,
            'config' => null,
            'id' => null
        ];
        $array = $this->transformer->toArray($modifier);
        $this->assertEquals($expected, $array);

        $expected = [
            'productId' => null,
            'name' => 'Name',
            'displayName' => 'Display Name',
            'type' => 'file',
            'required' => false,
            'sortOrder' => null,
            'config' => null,
            'id' => null
        ];

        $array = $this->transformer->toArray($modifier, Mapper::KEY_BY_PROPERTY_NAME);
        $this->assertEquals($expected, $array);
    }
}
