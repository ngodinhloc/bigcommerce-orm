<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Relation\Handlers\Exceptions;

use Bigcommerce\ORM\Exceptions\BaseException;

class HandlerException extends BaseException
{
    const ERROR_INVALID_MANY_RELATION_VALUE = 'Value of ManyRelation field must be int, or array of int. Provided value: ';
    const ERROR_INVALID_ONE_RELATION_VALUE = 'Value of OneRelation field must be int. Provided value: ';
}