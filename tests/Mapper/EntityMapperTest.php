<?php

namespace Tests\Mapper;

use Bigcommerce\ORM\Entities\ProductModifier;
use Bigcommerce\ORM\Mapper\EntityReader;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class EntityMapperTest extends TestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Mapper\EntityReader */
    private $entityReader;

    protected function setUp(): void
    {
        parent::setUp();
        $this->entityReader = new EntityReader();
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testGetProperty()
    {
        $modifier = new ProductModifier();
        $modifier
            ->setName('Name')
            ->setType('file')
            ->setDisplayName('Display Name');
        $this->assertFalse($this->entityReader->getProperty($modifier, 'invalid'));
        $property = $this->entityReader->getProperty($modifier, 'name');
        $this->assertInstanceOf(ReflectionProperty::class, $property);
        $this->assertEquals('name', $property->getName());
    }

    public function testSetPropertyValue()
    {
        $modifier = new ProductModifier();
        $modifier
            ->setName('Name')
            ->setType('file')
            ->setDisplayName('Display Name');
        $property = new ReflectionProperty(ProductModifier::class, 'name');
        $this->entityReader->setPropertyValue($modifier, $property, 'New Name');
        $this->assertEquals('New Name', $modifier->getName());
    }
}
