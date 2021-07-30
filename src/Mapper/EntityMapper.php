<?php

declare(strict_types=1);

namespace Bigcommerce\ORM\Mapper;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Annotations\Resource;
use Bigcommerce\ORM\Exceptions\EntityException;
use Bigcommerce\ORM\Exceptions\MapperException;
use Bigcommerce\ORM\Meta\MetadataBuilder;
use Bigcommerce\ORM\Validation\ValidationInterface;
use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class Mapper
 * @package Bigcommerce\ORM
 */
class EntityMapper
{
    /** @var \Doctrine\Common\Annotations\AnnotationReader */
    protected $reader;

    /** @var \Bigcommerce\ORM\Mapper\EntityReader */
    protected $entityReader;

    /** @var \Bigcommerce\ORM\Mapper\EntityTransformer */
    protected $entityTransformer;

    /** @var \Bigcommerce\ORM\Mapper\EntityPatcher */
    protected $entityPatcher;

    /** @var \Bigcommerce\ORM\Mapper\EntityValidator */
    protected $entityValidator;

    /** @var \Bigcommerce\ORM\Meta\MetadataBuilder */
    protected $metadataBuilder;

    /**
     * Mapper constructor.
     *
     * @param \Doctrine\Common\Annotations\AnnotationReader|null $reader reader
     */
    public function __construct(?AnnotationReader $reader = null)
    {
        $this->reader = $reader ?: new AnnotationReader();
        $this->entityReader = new EntityReader($this->reader);
        $this->metadataBuilder = new MetadataBuilder($this->reader);
        $this->entityPatcher = new EntityPatcher($this->reader, $this->entityReader, $this->metadataBuilder);
        $this->entityTransformer = new EntityTransformer($this->reader, $this->entityReader, $this->entityPatcher);
        $this->entityValidator = new EntityValidator();
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param string|null $action
     * @return string
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function getResourcePath(AbstractEntity $entity, ?string $action = null)
    {
        if ($entity->isPatched() !== true) {
            $entity = $this->entityPatcher->patch($entity, [], null, true);
        }

        $resource = $entity->getMetadata()->getResource();
        if (empty($resource->path)) {
            throw new EntityException(EntityException::ERROR_EMPTY_RESOURCE_PATH . $resource->name);
        }

        if (!empty($action)) {
            $this->checkResourceAction($resource, $action);
        }

        $path = $resource->path;
        $paramFields = $entity->getMetadata()->getParamFields();
        if (empty($paramFields)) {
            return $path;
        }

        foreach ($paramFields as $fieldName => $property) {
            $value = $this->entityReader->getPropertyValue($entity, $property);
            if (empty($value)) {
                throw new MapperException(sprintf(MapperException::ERROR_MISSING_PATH_PARAMS, $path, $fieldName));
            }
            $path = str_replace("{{$fieldName}}", "{$value}", $path);
        }

        if (preg_match('/{.*}/', $path)) {
            throw new MapperException(sprintf(MapperException::ERROR_PATH_PARAMS_REQUIRED, $path));
        }

        return $path;
    }

    /**
     * Check for entity required fields
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @return bool|array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function checkRequiredFields(AbstractEntity $entity)
    {
        if ($entity->isPatched() !== true) {
            $entity = $this->entityPatcher->patch($entity, [], null, true);
        }

        if (empty($requiredFields = $entity->getMetadata()->getRequiredFields())) {
            return true;
        }

        $missingFields = [];
        /* @var \ReflectionProperty $property */
        foreach ($requiredFields as $fieldName => $property) {
            if ($this->entityReader->getPropertyValue($entity, $property) === null) {
                $missingFields[$fieldName] = $property->name;
            }
        }

        if (empty($missingFields)) {
            return true;
        }

        return $missingFields;
    }

    /**
     * Get writable data
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param array|null $data
     * @return array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function getWritableFieldValues(AbstractEntity $entity, ?array $data = null)
    {
        if ($entity->isPatched() !== true) {
            $entity = $this->entityPatcher->patch($entity, [], null, true);
        }

        if (empty($data)) {
            $data = $this->entityTransformer->entityToArray($entity);
        }

        if (empty($readonlyFields = $entity->getMetadata()->getReadonlyFields())) {
            return $data;
        }

        return array_diff_key($data, $readonlyFields);
    }

    /**
     * Check for entity validations
     *
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @return bool|array
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function checkRequiredValidations(AbstractEntity $entity)
    {
        if ($entity->isPatched() !== true) {
            $entity = $this->entityPatcher->patch($entity, [], null, true);
        }

        if (empty($validationProperties = $entity->getMetadata()->getValidationProperties())) {
            return true;
        }

        $validationRules = [];
        /* @var \ReflectionProperty $property */
        foreach ($validationProperties as $propertyName => $rule) {
            $property = $rule['property'];
            $annotation = $rule['annotation'];
            if ($annotation instanceof ValidationInterface) {
                $validator = $annotation->getValidator($this);
                $check = $validator->validate($entity, $property, $annotation);
                if (!$check) {
                    $validationRules[$propertyName] = $property->name . ": " . get_class($annotation);
                }
            }
        }

        if (empty($validationRules)) {
            return true;
        }

        return $validationRules;
    }

    /**
     * @param \Bigcommerce\ORM\Annotations\Resource|null $resource
     * @param string|null $action
     * @return bool
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    private function checkResourceAction(?Resource $resource = null, ?string $action = null)
    {
        switch ($action) {
            case 'find':
                if ($resource->findable !== true) {
                    throw new EntityException(EntityException::ERROR_NOT_FINDABLE_RESOURCE . $resource->name);
                }
                break;
            case 'create':
                if ($resource->creatable !== true) {
                    throw new EntityException(EntityException::ERROR_NOT_CREATABLE_RESOURCE . $resource->name);
                }
                break;
            case 'update':
                if ($resource->updatable !== true) {
                    throw new EntityException(EntityException::ERROR_NOT_UPDATABLE_RESOURCE . $resource->name);
                }
                break;
            case 'delete':
                if ($resource->deletable !== true) {
                    throw new EntityException(EntityException::ERROR_NOT_DELETABLE_RESOURCE . $resource->name);
                }
                break;
        }

        return true;
    }

    /**
     * @return \Bigcommerce\ORM\Mapper\EntityReader
     */
    public function getEntityReader(): \Bigcommerce\ORM\Mapper\EntityReader
    {
        return $this->entityReader;
    }

    /**
     * @param \Bigcommerce\ORM\Mapper\EntityReader $entityReader
     * @return \Bigcommerce\ORM\Mapper\EntityMapper
     */
    public function setEntityReader(\Bigcommerce\ORM\Mapper\EntityReader $entityReader): EntityMapper
    {
        $this->entityReader = $entityReader;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Mapper\EntityTransformer
     */
    public function getEntityTransformer(): \Bigcommerce\ORM\Mapper\EntityTransformer
    {
        return $this->entityTransformer;
    }

    /**
     * @param \Bigcommerce\ORM\Mapper\EntityTransformer $entityTransformer
     * @return \Bigcommerce\ORM\Mapper\EntityMapper
     */
    public function setEntityTransformer(\Bigcommerce\ORM\Mapper\EntityTransformer $entityTransformer): EntityMapper
    {
        $this->entityTransformer = $entityTransformer;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Meta\MetadataBuilder
     */
    public function getMetadataBuilder(): \Bigcommerce\ORM\Meta\MetadataBuilder
    {
        return $this->metadataBuilder;
    }

    /**
     * @param \Bigcommerce\ORM\Meta\MetadataBuilder $metadataBuilder
     * @return \Bigcommerce\ORM\Mapper
     */
    public function setMetadataBuilder(\Bigcommerce\ORM\Meta\MetadataBuilder $metadataBuilder): EntityMapper
    {
        $this->metadataBuilder = $metadataBuilder;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Mapper\EntityPatcher
     */
    public function getEntityPatcher(): \Bigcommerce\ORM\Mapper\EntityPatcher
    {
        return $this->entityPatcher;
    }

    /**
     * @param \Bigcommerce\ORM\Mapper\EntityPatcher $entityPatcher
     * @return \Bigcommerce\ORM\Mapper\EntityMapper
     */
    public function setEntityPatcher(\Bigcommerce\ORM\Mapper\EntityPatcher $entityPatcher): EntityMapper
    {
        $this->entityPatcher = $entityPatcher;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Mapper\EntityValidator
     */
    public function getEntityValidator(): \Bigcommerce\ORM\Mapper\EntityValidator
    {
        return $this->entityValidator;
    }

    /**
     * @param \Bigcommerce\ORM\Mapper\EntityValidator $entityValidator
     * @return \Bigcommerce\ORM\Mapper
     */
    public function setEntityValidator(\Bigcommerce\ORM\Mapper\EntityValidator $entityValidator): EntityMapper
    {
        $this->entityValidator = $entityValidator;

        return $this;
    }
}
