<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Exceptions;

/**
 * Class ManagerFactoryException
 * @package Bigcommerce\ORM\Exceptions
 */
class ManagerFactoryException extends BaseException
{
    const MGS_CONFIG_NOT_FOUND = 'Config not found for: ';
    const MGS_CREDENTIALS_NOT_FOUND = 'Credentials not found for: ';
}
