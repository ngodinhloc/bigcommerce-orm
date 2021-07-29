<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Exceptions;

class HandlerException extends OrmException
{
    const ERROR_INVALID_MANY_RELATION_VALUE = 'Value of ManyRelation field must be int|string, or array of int|string. Provided value: ';
    const ERROR_INVALID_ONE_RELATION_VALUE = 'Value of OneRelation field must be int|string. Provided value: ';
}
