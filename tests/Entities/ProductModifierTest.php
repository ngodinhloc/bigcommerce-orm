<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductModifier;
use Tests\BaseTestCase;

class ProductModifierTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Entities\ProductModifier */
    protected $entity;

    /**
     * testSettersAndGetters
     */
    public function testSettersAndGetters()
    {
        $this->entity = new ProductModifier();
        $this->entity
            ->setProductId(111)
            ->setSortOrder(1)
            ->setId(2)
            ->setType('file')
            ->setName('upload_file')
            ->setDisplayName('Upload File')
            ->setConfig([])
            ->setOptionValues([])
            ->setRequired(false);

        $this->assertEquals(111, $this->entity->getProductId());
        $this->assertEquals(1, $this->entity->getSortOrder());
        $this->assertEquals(2, $this->entity->getId());
        $this->assertEquals('file', $this->entity->getType());
        $this->assertEquals('upload_file', $this->entity->getName());
        $this->assertEquals('Upload File', $this->entity->getDisplayName());
        $this->assertEquals([], $this->entity->getConfig());
        $this->assertEquals([], $this->entity->getOptionValues());
        $this->assertEquals(false, $this->entity->isRequired());
    }
}
