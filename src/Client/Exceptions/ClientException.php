<?php

namespace Bigcommerce\ORM\Client\Exceptions;

use Bigcommerce\ORM\Exceptions\BaseException;

class ClientException extends BaseException
{
    const MSG_QUERY_MISSING = 'Query string is empty.';
    const MSG_FAILED_TO_QUERY_OBJECT = 'Failed to query objects: ';
    const MSG_FAILED_TO_CREATE_OBJECT = 'Failed to creat object: ';
    const MSG_FAILED_TO_UPDATE_OBJECT = 'Failed to update object: ';
}
