<?php

namespace Tests\Mapper;

use Bigcommerce\ORM\Mapper\EntityMapper;
use Bigcommerce\ORM\Mapper\EntityPatcher;
use Bigcommerce\ORM\Mapper\EntityReader;
use Bigcommerce\ORM\Mapper\EntityTransformer;
use Bigcommerce\ORM\Mapper\EntityValidator;
use Bigcommerce\ORM\Meta\MetadataBuilder;
use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;

class EntityMapperTest extends TestCase
{
    /** @var \Bigcommerce\ORM\Mapper\EntityMapper */
    private $mapper;

    public function testSettersAndGetters()
    {
        $this->mapper = new EntityMapper();
        $reader = new AnnotationReader();
        $entityReader = new EntityReader($reader);
        $metadataBuilder = new MetadataBuilder($reader);
        $entityPatcher = new EntityPatcher($reader, $entityReader, $metadataBuilder);
        $entityTransformer = new EntityTransformer($reader, $entityReader, $entityPatcher);
        $entityValidator = new EntityValidator();

        $this->mapper
            ->setEntityReader($entityReader)
            ->setMetadataBuilder($metadataBuilder)
            ->setEntityPatcher($entityPatcher)
            ->setEntityTransformer($entityTransformer)
            ->setEntityValidator($entityValidator);

        $this->assertSame($entityReader, $this->mapper->getEntityReader());
        $this->assertSame($metadataBuilder, $this->mapper->getMetadataBuilder());
        $this->assertSame($entityPatcher, $this->mapper->getEntityPatcher());
        $this->assertSame($entityTransformer, $this->mapper->getEntityTransformer());
        $this->assertSame($entityValidator, $this->mapper->getEntityValidator());
    }
}
