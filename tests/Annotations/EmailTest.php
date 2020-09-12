<?php
declare(strict_types=1);

namespace Tests\Annotations;

use Bigcommerce\ORM\Annotations\Email;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\Validation\Validators\EmailValidator;
use Tests\BaseTestCase;

class EmailTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Annotations\Email */
    protected $annotation;

    /**
     * @covers \Bigcommerce\ORM\Annotations\Email::getValidator
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testDate()
    {
        $this->annotation = new Email(['validate' => true]);
        $this->assertEquals(true, $this->annotation->validate);

        $mapper = $this->prophet->prophesize(Mapper::class)->reveal();
        /** @var \Bigcommerce\ORM\Validation\Validators\EmailValidator $validator */
        $validator = $this->annotation->getValidator($mapper);
        $this->assertInstanceOf(EmailValidator::class, $validator);
        $this->assertEquals($mapper, $validator->getMapper());
    }
}