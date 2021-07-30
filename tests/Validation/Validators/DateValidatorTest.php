<?php
declare(strict_types=1);

namespace Tests\Validation\Validators;

use Bigcommerce\ORM\Entities\Customer;
use Bigcommerce\ORM\Mapper;
use Bigcommerce\ORM\Validation\Validators\DateValidator;
use Tests\BaseTestCase;

class DateValidatorTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Validation\Validators\DateValidator */
    protected $validator;

    /** @var \Bigcommerce\ORM\Mapper */
    protected $mapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mapper = new Mapper();
    }

    /**
     * @covers \Bigcommerce\ORM\Validation\Validators\DateValidator::__construct
     * @covers \Bigcommerce\ORM\Validation\Validators\DateValidator::validate
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testValidate()
    {
        $this->validator = new DateValidator($this->mapper);

        $entity = new Customer();
        $property = $this->mapper->getEntityReader()->getProperty($entity, 'dateCreated');
        $annotation = new \Bigcommerce\ORM\Annotations\Date([]);

        $entity->setDateCreated(null);
        $result = $this->validator->validate($entity, $property, $annotation);
        $this->assertEquals(true, $result);

        $entity->setDateCreated('2020-09-14');
        $result = $this->validator->validate($entity, $property, $annotation);
        $this->assertEquals(true, $result);
    }

}
