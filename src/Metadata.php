<?php
declare(strict_types=1);

namespace Bigcommerce\ORM;

use Bigcommerce\ORM\Annotations\Resource;

class Metadata
{
    /**
     * @var \Bigcommerce\ORM\Annotations\Resource
     */
    protected $resource;

    /**
     * @var array
     */
    protected $relationFields;

    /**
     * @var array
     */
    protected $includeFields;

    /**
     * @var array
     */
    protected $autoLoadFields;

    /**
     * @var array
     */
    protected $inResultFields;

    /**
     * @var array
     */
    protected $requiredFields;

    /**
     * @var array
     */
    protected $readonlyFields;

    /**
     * @var array
     */
    protected $customisedFields;

    /**
     * @var array
     */
    protected $paramFields;

    /**
     * @var array
     */
    protected $uploadFields;

    /**
     * @var array
     */
    protected $validationProperties;

    /**
     * @return \Bigcommerce\ORM\Annotations\Resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param \Bigcommerce\ORM\Annotations\Resource $resource
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setResource(Resource $resource): Metadata
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * @return array
     */
    public function getRelationFields(): array
    {
        return $this->relationFields;
    }

    /**
     * @param array $relationFields
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setRelationFields(array $relationFields): Metadata
    {
        $this->relationFields = $relationFields;

        return $this;
    }

    /**
     * @return array
     */
    public function getIncludeFields(): array
    {
        return $this->includeFields;
    }

    /**
     * @param array $includeFields
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setIncludeFields(array $includeFields): Metadata
    {
        $this->includeFields = $includeFields;

        return $this;
    }

    /**
     * @return array
     */
    public function getAutoLoadFields(): array
    {
        return $this->autoLoadFields;
    }

    /**
     * @param array $autoLoadFields
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setAutoLoadFields(array $autoLoadFields): Metadata
    {
        $this->autoLoadFields = $autoLoadFields;

        return $this;
    }

    /**
     * @return array
     */
    public function getRequiredFields(): array
    {
        return $this->requiredFields;
    }

    /**
     * @param array $requiredFields
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setRequiredFields(array $requiredFields): Metadata
    {
        $this->requiredFields = $requiredFields;

        return $this;
    }

    /**
     * @return array
     */
    public function getReadonlyFields(): array
    {
        return $this->readonlyFields;
    }

    /**
     * @param array $readonlyFields
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setReadonlyFields(array $readonlyFields): Metadata
    {
        $this->readonlyFields = $readonlyFields;

        return $this;
    }

    /**
     * @return array
     */
    public function getCustomisedFields(): array
    {
        return $this->customisedFields;
    }

    /**
     * @param array $customisedFields
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setCustomisedFields(array $customisedFields): Metadata
    {
        $this->customisedFields = $customisedFields;

        return $this;
    }

    /**
     * @return array
     */
    public function getValidationProperties(): array
    {
        return $this->validationProperties;
    }

    /**
     * @param array $validationProperties
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setValidationProperties(array $validationProperties): Metadata
    {
        $this->validationProperties = $validationProperties;

        return $this;
    }

    /**
     * @return array
     */
    public function getUploadFields(): array
    {
        return $this->uploadFields;
    }

    /**
     * @param array $uploadFields
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setUploadFields(array $uploadFields): Metadata
    {
        $this->uploadFields = $uploadFields;

        return $this;
    }

    /**
     * @return array
     */
    public function getParamFields(): array
    {
        return $this->paramFields;
    }

    /**
     * @param array $paramFields
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setParamFields(array $paramFields): Metadata
    {
        $this->paramFields = $paramFields;

        return $this;
    }

    /**
     * @return array
     */
    public function getInResultFields()
    {
        return $this->inResultFields;
    }

    /**
     * @param array $inResultFields
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setInResultFields(array $inResultFields): Metadata
    {
        $this->inResultFields = $inResultFields;

        return $this;
    }
}
