<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Exceptions;

class ResultException extends OrmException
{
    const ERROR_NO_RESPONSE_PROVIDED = 'No response provided. Please set response.';
}
