<?php
declare(strict_types=1);

namespace Tests\Validation\Validators;

use Bigcommerce\ORM\Entities\ProductImage;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\Validation\Validators\FileValidator;
use Tests\BaseTestCase;

class FileValidatorTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Validation\Validators\FileValidator */
    protected $validator;

    /** @var \Bigcommerce\ORM\Mapper */
    protected $mapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mapper = new Mapper();
    }

    /**
     * @covers \Bigcommerce\ORM\Validation\Validators\FileValidator::__construct
     * @covers \Bigcommerce\ORM\Validation\Validators\FileValidator::validate
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testValidate()
    {
        $this->validator = new FileValidator($this->mapper);

        $entity = new ProductImage();
        $property = $this->mapper->getProperty($entity, 'imageFile');
        $annotation = new \Bigcommerce\ORM\Annotations\File([]);

        $file = dirname(dirname(__DIR__)) . '/assets/images/lamp.jpg';
        $entity->setImageFile(null);
        $result = $this->validator->validate($entity, $property, $annotation);
        $this->assertEquals(true, $result);

        $entity->setImageFile($file);
        $result = $this->validator->validate($entity, $property, $annotation);
        $this->assertEquals(true, $result);
    }

}