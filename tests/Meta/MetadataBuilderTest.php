<?php

namespace Tests\Meta;

use Bigcommerce\ORM\Annotations\Resource;
use Bigcommerce\ORM\Entities\Product;
use Bigcommerce\ORM\Entities\ProductModifier;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\Mapper\Reflection;
use Bigcommerce\ORM\Meta\Metadata;
use Bigcommerce\ORM\Meta\MetadataBuilder;
use PHPUnit\Framework\TestCase;

class MetadataBuilderTest extends TestCase
{
    /** @var \Bigcommerce\ORM\Meta\MetadataBuilder */
    private $builder;

    /** @var \Bigcommerce\ORM\Mapper */
    private $mapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new MetadataBuilder();
        $this->mapper = new Mapper();
    }

    /**
     * @covers \Bigcommerce\ORM\Meta\MetadataBuilder::build
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testBuild()
    {
        $product = new Product();
        $data = [
            'name' => 'Product Name',
            'type' => 'physic',
            'primary_image' => [
                "id" => 372,
                "product_id" => 111,
                "is_thumbnail" => true,
                "sort_order" => 1,
                "description" => "",
                "image_file" => "lamp.jpg",
            ],
            'images' => [
                [
                    "id" => 372,
                    "product_id" => 111,
                    "is_thumbnail" => false,
                    "sort_order" => 1,
                    "description" => "",
                    "image_file" => "lamp.jpg",
                ],
            ]
        ];

        $reflectionClass = (new Reflection())->reflect($product);
        $properties = $reflectionClass->getProperties();
        $resource = $this->mapper->getEntityPatcher()->getResource($product);
        $metadata = $this->builder->build($resource, $properties);
        $relationFields = $metadata->getRelationFields();
        $includeFields = $metadata->getIncludeFields();
        $autoLoadFields = $metadata->getAutoLoadFields();
        $requiredFields = $metadata->getRequiredFields();
        $readonlyFields = $metadata->getReadonlyFields();

        $this->assertInstanceOf(Metadata::class, $metadata);
        $this->assertInstanceOf(Resource::class, $resource);
        $this->assertEquals(9, count($relationFields));
        $this->assertEquals(7, count($includeFields));
        $this->assertEquals(2, count($autoLoadFields));
        $this->assertEquals(1, count($requiredFields));
        $this->assertEquals(3, count($readonlyFields));
    }
}
