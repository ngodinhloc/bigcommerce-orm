<?php
declare(strict_types=1);

namespace Tests\Validation\Validators;

use Bigcommerce\ORM\Entities\Customer;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\Validation\Validators\UrlValidator;
use Tests\BaseTestCase;

class UrlValidatorTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Validation\Validators\UrlValidator */
    protected $validator;

    /** @var \Bigcommerce\ORM\Mapper */
    protected $mapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mapper = new Mapper();
    }

    /**
     * @covers \Bigcommerce\ORM\Validation\Validators\UrlValidator::__construct
     * @covers \Bigcommerce\ORM\Validation\Validators\UrlValidator::validate
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testValidate()
    {
        $this->validator = new UrlValidator($this->mapper);

        $entity = new Customer();
        $property = $this->mapper->getProperty($entity, 'email');
        $annotation = new \Bigcommerce\ORM\Annotations\Url([]);

        $entity->setEmail(null);
        $result = $this->validator->validate($entity, $property, $annotation);
        $this->assertEquals(true, $result);

        $entity->setEmail('http://www.bigcommerce.com');
        $result = $this->validator->validate($entity, $property, $annotation);
        $this->assertEquals('http://www.bigcommerce.com', $result);
    }

}
