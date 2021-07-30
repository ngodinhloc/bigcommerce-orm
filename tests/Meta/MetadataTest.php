<?php
declare(strict_types=1);

namespace Tests\Meta;

use Bigcommerce\ORM\Annotations\Resource;
use Bigcommerce\ORM\Meta\Metadata;
use Tests\BaseTestCase;

class MetadataTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\Meta\Metadata */
    protected $metadata;

    protected function setUp(): void
    {
        parent::setUp();
        $this->metadata = new Metadata();
    }

    /**
     * @covers \Bigcommerce\ORM\Meta\Metadata::setResource
     * @covers \Bigcommerce\ORM\Meta\Metadata::setRelationFields
     * @covers \Bigcommerce\ORM\Meta\Metadata::setUploadFields
     * @covers \Bigcommerce\ORM\Meta\Metadata::setIncludeFields
     * @covers \Bigcommerce\ORM\Meta\Metadata::setValidationProperties
     * @covers \Bigcommerce\ORM\Meta\Metadata::setCustomisedFields
     * @covers \Bigcommerce\ORM\Meta\Metadata::setReadonlyFields
     * @covers \Bigcommerce\ORM\Meta\Metadata::setAutoLoadFields
     * @covers \Bigcommerce\ORM\Meta\Metadata::setRequiredFields
     * @covers \Bigcommerce\ORM\Meta\Metadata::getResource
     * @covers \Bigcommerce\ORM\Meta\Metadata::getRelationFields
     * @covers \Bigcommerce\ORM\Meta\Metadata::getUploadFields
     * @covers \Bigcommerce\ORM\Meta\Metadata::getIncludeFields
     * @covers \Bigcommerce\ORM\Meta\Metadata::getValidationProperties
     * @covers \Bigcommerce\ORM\Meta\Metadata::getCustomisedFields
     * @covers \Bigcommerce\ORM\Meta\Metadata::getReadonlyFields
     * @covers \Bigcommerce\ORM\Meta\Metadata::getAutoLoadFields
     * @covers \Bigcommerce\ORM\Meta\Metadata::getRequiredFields
     */
    public function testSettersAndGetters()
    {
        $bigObject = new Resource([]);
        $this->metadata
            ->setResource($bigObject)
            ->setRelationFields([])
            ->setUploadFields([])
            ->setIncludeFields([])
            ->setValidationProperties([])
            ->setCustomisedFields([])
            ->setReadonlyFields([])
            ->setAutoLoadFields([])
            ->setRequiredFields([])
            ->setInResultFields([])
            ->setParamFields([]);
        $this->assertEquals($bigObject, $this->metadata->getResource());
        $this->assertEquals([], $this->metadata->getRelationFields());
        $this->assertEquals([], $this->metadata->getUploadFields());
        $this->assertEquals([], $this->metadata->getIncludeFields());
        $this->assertEquals([], $this->metadata->getValidationProperties());
        $this->assertEquals([], $this->metadata->getCustomisedFields());
        $this->assertEquals([], $this->metadata->getReadonlyFields());
        $this->assertEquals([], $this->metadata->getAutoLoadFields());
        $this->assertEquals([], $this->metadata->getRequiredFields());
        $this->assertEquals([], $this->metadata->getInResultFields());
        $this->assertEquals([], $this->metadata->getParamFields());
    }
}
