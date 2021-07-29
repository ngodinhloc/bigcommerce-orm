<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Exceptions;

/**
 * Class RepositoryException
 * @package Bigcommerce\ORM\Exceptions
 */
class RepositoryException extends OrmException
{
    const MSG_NO_CLASS_NAME_PROVIDED = "No class provided. Please check repository class.";
}
