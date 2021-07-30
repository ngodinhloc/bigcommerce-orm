<?php

namespace Tests\Mapper;

use Bigcommerce\ORM\Entities\ProductModifier;
use Bigcommerce\ORM\Mapper\EntityMapper;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class EntityMapperTest extends TestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Mapper\EntityMapper */
    private $entityMapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->entityMapper = new EntityMapper();
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
        $this->assertFalse($this->entityMapper->getProperty($modifier, 'invalid'));
        $property = $this->entityMapper->getProperty($modifier, 'name');
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
        $this->entityMapper->setPropertyValue($modifier, $property, 'New Name');
        $this->assertEquals('New Name', $modifier->getName());
    }
}
