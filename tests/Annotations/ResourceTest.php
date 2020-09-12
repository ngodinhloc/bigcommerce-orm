<?php
declare(strict_types=1);

namespace Tests\Annotations;

use Bigcommerce\ORM\Annotations\Resource;
use Tests\BaseTestCase;

class ResourceTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Annotations\Resource */
    protected $resource;

    public function testBigObject(){
        $this->resource = new Resource(['name' => 'Customer', 'path' => '/customers', 'parentField' => null]);
        $this->assertEquals('Customer', $this->resource->name);
        $this->assertEquals('/customers', $this->resource->path);
        $this->assertEquals(null, $this->resource->parentField);
    }
}