<?php
declare(strict_types=1);

namespace Tests\Validation\Validators;

use Bigcommerce\ORM\Entities\Customer;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\Validation\Validators\EmailValidator;
use Tests\BaseTestCase;

class EmailValidatorTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Validation\Validators\EmailValidator */
    protected $validator;

    /** @var \Bigcommerce\ORM\Mapper */
    protected $mapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mapper = new Mapper();
    }

    /**
     * @covers \Bigcommerce\ORM\Validation\Validators\EmailValidator::__construct
     * @covers \Bigcommerce\ORM\Validation\Validators\EmailValidator::validate
     * @covers \Bigcommerce\ORM\Validation\Validators\EmailValidator::setMapper
     * @covers \Bigcommerce\ORM\Validation\Validators\EmailValidator::getMapper
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testValidate()
    {
        $this->validator = new EmailValidator($this->mapper);
        $this->validator->setMapper($this->mapper);
        $this->assertEquals($this->mapper, $this->validator->getMapper());

        $entity = new Customer();
        $property = $this->mapper->getEntityReader()->getProperty($entity, 'email');
        $annotation = new \Bigcommerce\ORM\Annotations\Email([]);

        $entity->setEmail(null);
        $result = $this->validator->validate($entity, $property, $annotation);
        $this->assertEquals(true, $result);

        $entity->setEmail('ken.ngo@bigcommerce.com');
        $result = $this->validator->validate($entity, $property, $annotation);
        $this->assertEquals('ken.ngo@bigcommerce.com', $result);
    }

}
