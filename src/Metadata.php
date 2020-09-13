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
    protected $autoIncludes;

    /**
     * @var array
     */
    protected $autoLoads;

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
    protected $requiredValidations;

    /**
     * @var array
     */
    protected $uploadFiles;

    /**
     * @var array
     */
    protected $parentFields;

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
    public function getAutoIncludes(): array
    {
        return $this->autoIncludes;
    }

    /**
     * @param array $autoIncludes
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setAutoIncludes(array $autoIncludes): Metadata
    {
        $this->autoIncludes = $autoIncludes;
        return $this;
    }

    /**
     * @return array
     */
    public function getAutoLoads(): array
    {
        return $this->autoLoads;
    }

    /**
     * @param array $autoLoads
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setAutoLoads(array $autoLoads): Metadata
    {
        $this->autoLoads = $autoLoads;
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
    public function getRequiredValidations(): array
    {
        return $this->requiredValidations;
    }

    /**
     * @param array $requiredValidations
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setRequiredValidations(array $requiredValidations): Metadata
    {
        $this->requiredValidations = $requiredValidations;
        return $this;
    }

    /**
     * @return array
     */
    public function getUploadFiles(): array
    {
        return $this->uploadFiles;
    }

    /**
     * @param array $uploadFiles
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setUploadFiles(array $uploadFiles): Metadata
    {
        $this->uploadFiles = $uploadFiles;
        return $this;
    }

    /**
     * @return array
     */
    public function getParentFields(): array
    {
        return $this->parentFields;
    }

    /**
     * @param array $parentFields
     * @return \Bigcommerce\ORM\Metadata
     */
    public function setParentFields(array $parentFields): Metadata
    {
        $this->parentFields = $parentFields;
        return $this;
    }

}
