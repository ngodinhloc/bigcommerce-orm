<?php
declare(strict_types=1);

namespace Tests\Annotations;

use Bigcommerce\ORM\Annotations\File;
use Bigcommerce\ORM\Mapper\EntityMapper;
use Bigcommerce\ORM\Validation\Validators\FileValidator;
use Tests\BaseTestCase;

class FileTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Annotations\File */
    protected $annotation;

    /**
     * @covers \Bigcommerce\ORM\Annotations\File::getValidator
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testDate()
    {
        $this->annotation = new File(['validate' => true]);
        $this->assertEquals(true, $this->annotation->validate);

        $mapper = $this->prophet->prophesize(EntityMapper::class)->reveal();
        /** @var \Bigcommerce\ORM\Validation\Validators\FileValidator $validator */
        $validator = $this->annotation->getValidator($mapper);
        $this->assertInstanceOf(FileValidator::class, $validator);
        $this->assertEquals($mapper, $validator->getMapper());
    }
}
