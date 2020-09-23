<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Client\Exceptions;

use Bigcommerce\ORM\Exceptions\BaseException;

class ConfigException extends BaseException
{
    const ERROR_MISSING_CONFIG = "Configs are missing. Required following data: ";
}
