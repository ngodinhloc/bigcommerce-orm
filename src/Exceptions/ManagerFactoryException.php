<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Exceptions;

/**
 * Class ManagerFactoryException
 * @package Bigcommerce\ORM\Exceptions
 */
class ManagerFactoryException extends OrmException
{
    const ERROR_CONFIG_NOT_FOUND = 'Config not found for: ';
    const ERROR_CREDENTIALS_NOT_FOUND = 'Credentials not found for: ';
}
