<?php

namespace Bigcommerce\ORM\Client\Exceptions;

use Bigcommerce\ORM\Exceptions\BaseException;

class ClientException extends BaseException
{
    const ERROR_QUERY_MISSING = 'Query string is empty.';
    const ERROR_FAILED_TO_QUERY_OBJECT = 'Failed to query objects. Query: %s. Error: %s';
    const ERROR_FAILED_TO_CREATE_OBJECT = 'Failed to creat object. Query: %s. Error: %s';
    const ERROR_FAILED_TO_UPDATE_OBJECT = 'Failed to update object. Query: %s. Error: %s';
}
