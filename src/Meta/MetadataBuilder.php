<?php

namespace Bigcommerce\ORM\Meta;

use Bigcommerce\ORM\Annotations\Field;
use Bigcommerce\ORM\Annotations\Resource;
use Bigcommerce\ORM\Relation\RelationInterface;
use Bigcommerce\ORM\Validation\ValidationInterface;
use Doctrine\Common\Annotations\AnnotationReader;

class MetadataBuilder
{
    protected \Doctrine\Common\Annotations\AnnotationReader $reader;

    /**
     * MetadataBuilder constructor.
     * @param \Doctrine\Common\Annotations\AnnotationReader|null $reader
     */
    public function __construct(?AnnotationReader $reader = null)
    {
        $this->reader = $reader ?: new AnnotationReader();
    }

    /**
     * @param \Bigcommerce\ORM\Annotations\Resource|null $resource
     * @param \ReflectionProperty[] $properties
     * @return \Bigcommerce\ORM\Meta\Metadata
     */
    public function build(?Resource $resource = null, ?array $properties = null)
    {
        $relationFields = [];
        $autoLoadFields = [];
        $includeFields = [];
        $inResultFields = [];
        $requiredFields = [];
        $readonlyFields = [];
        $customisedFields = [];
        $validationFields = [];
        $uploadFiles = [];
        $paramFields = [];

        foreach ($properties as $property) {
            $annotations = $this->reader->getPropertyAnnotations($property);
            foreach ($annotations as $annotation) {
                if ($annotation instanceof Field) {
                    if ($annotation->required == true) {
                        $requiredFields[$annotation->name] = $property;
                    }
                    if ($annotation->readonly == true) {
                        $readonlyFields[$annotation->name] = $property;
                    }
                    if ($annotation->customised == true) {
                        $customisedFields[$annotation->name] = $property;
                    }
                    if ($annotation->upload == true) {
                        $uploadFiles[$annotation->name] = $property;
                    }
                    if ($annotation->pathParam == true) {
                        $paramFields[$annotation->name] = $property;
                    }
                }

                if ($annotation instanceof RelationInterface) {
                    $relationFields[$annotation->name] = ['property' => $property, 'annotation' => $annotation];
                    if ($annotation->auto === true && $annotation->from === 'include') {
                        $includeFields[$annotation->name] = ['property' => $property, 'annotation' => $annotation];
                    }

                    if ($annotation->auto === true && $annotation->from === 'api') {
                        $autoLoadFields[$annotation->name] = ['property' => $property, 'annotation' => $annotation];
                    }

                    if ($annotation->from === 'result') {
                        $inResultFields[$annotation->name] = ['property' => $property, 'annotation' => $annotation];
                    }
                }

                if ($annotation instanceof ValidationInterface) {
                    if ($annotation->validate === true) {
                        $validationFields[$property->name] = ['property' => $property, 'annotation' => $annotation];
                    }
                }
            }
        }

        $metadata = new Metadata();
        $metadata
            ->setResource($resource)
            ->setReadonlyFields($readonlyFields)
            ->setRequiredFields($requiredFields)
            ->setCustomisedFields($customisedFields)
            ->setRelationFields($relationFields)
            ->setIncludeFields($includeFields)
            ->setAutoLoadFields($autoLoadFields)
            ->setInResultFields($inResultFields)
            ->setValidationProperties($validationFields)
            ->setUploadFields($uploadFiles)
            ->setParamFields($paramFields);

        return $metadata;
    }
}
