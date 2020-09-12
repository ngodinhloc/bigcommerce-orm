<?php
declare(strict_types=1);

namespace Tests\Annotations;

use Bigcommerce\ORM\Annotations\Resource;
use Tests\BaseTestCase;

class ResourceTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Annotations\Resource */
    protected $annotation;

    public function testResource(){
        $this->annotation = new Resource(['name' => 'Customer', 'path' => '/customers', 'parentField' => null]);
        $this->assertEquals('Customer', $this->annotation->name);
        $this->assertEquals('/customers', $this->annotation->path);
        $this->assertEquals(null, $this->annotation->parentField);
    }
}