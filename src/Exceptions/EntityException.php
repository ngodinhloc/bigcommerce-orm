<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Exceptions;

/**
 * Class EntityException
 * @package Bigcommerce\ORM\Exceptions
 */
class EntityException extends BaseException
{
    const MSG_EMPTY_CLASS_NAME = 'Empty class name provided: ';
    const MSG_REQUIRED_PROPERTIES = 'These properties are required: ';
    const MSG_REQUIRED_VALIDATIONS = 'Required validation rules: ';
    const MSG_ID_IS_NOT_PROVIDED = 'Id of the entity is not provided: ';
    const MSG_NOT_ENTITY_INSTANCE = 'Object is not an instance of Entity';
    const MSG_EMPTY_NONE_READONLY_DATA = 'There is not any none readonly data field provided.';
    const MSG_INVALID_UPLOAD_FILE = 'Upload is not an valid file: ';
    const MSG_DIFFERENT_CLASS_NAME = 'Batching only update entities of the same class.';
}
