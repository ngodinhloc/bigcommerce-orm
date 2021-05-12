<?php
declare(strict_types=1);

namespace Tests\Annotations;

use Bigcommerce\ORM\Annotations\Date;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\Validation\Validators\DateValidator;
use Tests\BaseTestCase;

class DateTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Annotations\Date */
    protected $annotation;

    /**
     * @covers \Bigcommerce\ORM\Annotations\Date::getValidator
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testDate()
    {
        $this->annotation = new Date(['format' => 'Y-m-d', 'validate' => true]);
        $this->assertEquals('Y-m-d', $this->annotation->format);
        $this->assertEquals(true, $this->annotation->validate);

        $mapper = $this->prophet->prophesize(Mapper::class)->reveal();
        /** @var \Bigcommerce\ORM\Validation\Validators\DateValidator $validator */
        $validator = $this->annotation->getValidator($mapper);
        $this->assertInstanceOf(DateValidator::class, $validator);
        $this->assertEquals($mapper, $validator->getMapper());
    }
}
