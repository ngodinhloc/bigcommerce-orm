<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductModifier;
use Tests\BaseTestCase;

class ProductModifierTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductModifier */
    protected $modifier;

    public function testSettersAndGetters(){
        $this->modifier = new ProductModifier();
        $this->modifier
            ->setProductId(111)
            ->setSortOrder(1)
            ->setId(2)
            ->setType('file')
            ->setName('upload_file')
            ->setDisplayName('Upload File')
            ->setConfig([])
            ->setOptionValues([])
            ->setRequired(false);

        $this->assertEquals(111, $this->modifier->getProductId());
        $this->assertEquals(1, $this->modifier->getSortOrder());
        $this->assertEquals(2, $this->modifier->getId());
        $this->assertEquals('file', $this->modifier->getType());
        $this->assertEquals('upload_file', $this->modifier->getName());
        $this->assertEquals('Upload File', $this->modifier->getDisplayName());
        $this->assertEquals([], $this->modifier->getConfig());
        $this->assertEquals([], $this->modifier->getOptionValues());
        $this->assertEquals(false, $this->modifier->isRequired());
    }
}