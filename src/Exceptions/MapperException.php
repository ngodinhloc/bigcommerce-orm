<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Exceptions;

/**
 * Class MapperException
 * @package Bigcommerce\ORM\Exceptions
 */
class MapperException extends OrmException
{
    const ERROR_MISSING_PATH_PARAMS = "Path params required. Path: %s. Missing: %s";
    const ERROR_PATH_PARAMS_REQUIRED = "Path params required. Path: %s.";
    const ERROR_FAILED_TO_CREATE_REFLECT_CLASS = 'Failed to create reflect class: ';
    const ERROR_OBJECT_TYPE_NOT_FOUND = 'Object type not found. Check class annotation: ';
    const ERROR_INVALID_CLASS_NAME = 'Class name not found: ';
    const ERROR_NO_CLASS_NAME_PROVIDED = "No class provided. Please check repository class.";
    const ERROR_NO_FIELD_FOUND = "No properties has been map for this field: ";
}
