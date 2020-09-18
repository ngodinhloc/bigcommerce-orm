<?php

namespace Bigcommerce\ORM\Client\Exceptions;

use Bigcommerce\ORM\Exceptions\BaseException;

class ResultException extends BaseException
{
    const ERROR_NO_RESPONSE_PROVIDED = 'No response provided. Please set response.';
}
