<?php

namespace Tests\Mapper;

use Bigcommerce\ORM\Exceptions\EntityException;
use Bigcommerce\ORM\Mapper\EntityValidator;
use PHPUnit\Framework\TestCase;

use function Webmozart\Assert\Tests\StaticAnalysis\null;

class EntityValidatorTest extends TestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Mapper\EntityValidator */
    private $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new EntityValidator();
    }

    /**
     * testCheckPropertyValues
     */
    public function testCheckFieldValuesWithNull()
    {
        $result = $this->validator->checkFieldValues(null);
        $this->assertFalse($result);
    }

    /**
     * testCheckNoneReadOnlyData
     */
    public function testCheckFieldValuesWithNoneReadOnlyData()
    {
        $expected = [
            'name' => 'name',
            'display_name' => 'display name',
            'type' => 'type',
            'required' => false,
            'sort_order' => 2,
            'config' => ['sku' => 111]
        ];

        $check = $this->validator->checkFieldValues($expected);
        $this->assertTrue($check);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function testCheckEntityThrowException()
    {
        $this->expectException(EntityException::class);
        $this->validator->checkEntity(null);
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function testCheckClass()
    {
        $this->expectException(EntityException::class);
        $this->validator->checkClass('');
    }

    /**
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function testCheckId()
    {
        $this->expectException(EntityException::class);
        $this->validator->checkId(0);
    }
}
