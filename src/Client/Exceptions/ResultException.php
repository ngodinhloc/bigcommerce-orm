<?php

namespace Bigcommerce\ORM\Client\Exceptions;

use Bigcommerce\ORM\Exceptions\BaseException;

class ResultException extends BaseException
{
    const MSG_NO_RESPONSE_PROVIDED = 'No response provided. Please set response.';
}
