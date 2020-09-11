<?php
declare(strict_types=1);

namespace Tests\Annotations;

use Bigcommerce\ORM\Annotations\BigObject;
use Tests\BaseTestCase;

class BigObjectTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Annotations\BigObject */
    protected $bigObject;

    public function testBigObject(){
        $this->bigObject = new BigObject(['name' => 'Customer', 'path' => '/customers', 'parentField' => null]);
        $this->assertEquals('Customer', $this->bigObject->name);
        $this->assertEquals('/customers', $this->bigObject->path);
        $this->assertEquals(null, $this->bigObject->parentField);
    }
}