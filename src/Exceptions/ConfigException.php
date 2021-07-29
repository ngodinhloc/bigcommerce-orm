<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Exceptions;

class ConfigException extends OrmException
{
    const ERROR_MISSING_CONFIG = "Configs are missing. Required following data: ";
}
