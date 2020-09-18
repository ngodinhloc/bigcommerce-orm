<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Exceptions;

/**
 * Class EntityException
 * @package Bigcommerce\ORM\Exceptions
 */
class EntityException extends BaseException
{
    const ERROR_EMPTY_CLASS_NAME = 'Empty class name provided: ';
    const ERROR_REQUIRED_PROPERTIES = 'These properties are required: ';
    const ERROR_REQUIRED_VALIDATIONS = 'Required validation rules: ';
    const ERROR_ID_IS_NOT_PROVIDED = 'Id of the entity is not provided: ';
    const ERROR_NOT_ENTITY_INSTANCE = 'Object is not an instance of Entity';
    const ERROR_EMPTY_NONE_READONLY_DATA = 'There is not any writable field data provided.';
    const ERROR_INVALID_UPLOAD_FILE = 'Upload is not an valid file: ';
    const ERROR_DIFFERENT_CLASS_NAME = 'Batching only update entities of the same class.';
    const ERROR_NOT_COUNTABLE_RESOURCE = 'This resource does not support count. Please try findAll: ';
    const ERROR_NOT_FINDABLE_RESOURCE = 'This resource does not support find. Please try findBy: ';
    const ERROR_NOT_CREATABLE_RESOURCE = 'This resource does not support create. Please try batchCreate: ';
    const ERROR_NOT_DELETABLE_RESOURCE = 'This resource does not support delete: ';
}
