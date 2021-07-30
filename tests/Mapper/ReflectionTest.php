<?php

namespace Tests\Mapper;

use Bigcommerce\ORM\Entities\ProductModifier;
use Bigcommerce\ORM\Mapper\Reflection;
use PHPUnit\Framework\TestCase;

class ReflectionTest extends TestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Mapper\Reflection */
    private $reflection;

   protected function setUp(): void
   {
       parent::setUp();
       $this->reflection = new Reflection();
   }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testReflectThrowException()
    {
        $this->expectException(\Throwable::class);
        $this->reflection->reflect(null);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function testReflect()
    {
        $modifier = new ProductModifier();
        $reflectionClass = $this->reflection->reflect($modifier);
        $this->assertInstanceOf(\ReflectionClass::class, $reflectionClass);
    }
}
