<?php
declare(strict_types=1);

namespace Tests\Annotations;

use Bigcommerce\ORM\Annotations\Url;
use Bigcommerce\ORM\Mapper\EntityMapper;
use Bigcommerce\ORM\Validation\Validators\UrlValidator;
use Tests\BaseTestCase;

class UrlTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Annotations\Url */
    protected $annotation;

    /**
     * @covers \Bigcommerce\ORM\Annotations\Url::getValidator
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testDate()
    {
        $this->annotation = new Url(['validate' => true]);
        $this->assertEquals(true, $this->annotation->validate);

        $mapper = $this->prophet->prophesize(EntityMapper::class)->reveal();
        /** @var \Bigcommerce\ORM\Validation\Validators\UrlValidator $validator */
        $validator = $this->annotation->getValidator($mapper);
        $this->assertInstanceOf(UrlValidator::class, $validator);
        $this->assertEquals($mapper, $validator->getMapper());
    }
}
