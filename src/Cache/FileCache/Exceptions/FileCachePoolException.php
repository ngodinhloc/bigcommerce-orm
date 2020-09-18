<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Cache\FileCache\Exceptions;

use Bigcommerce\ORM\Exceptions\BaseException;
use Psr\Cache\CacheException;

/**
 * Class CachePoolException
 * @package Bigcommerce\ORM\Cache\FileCache\Exceptions
 */
class FileCachePoolException extends BaseException implements CacheException
{
    const ERROR_INVALID_CACHE_DIR = 'Invalid cache dir: ';
    const ERROR_FAILED_ENCODE_DATA = 'Failed to encode data: ';
    const ERROR_FAILED_TO_PUT_CONTENT = 'Failed to put file content';
    const ERROR_FAILED_TO_GET_CONTENT = 'Failed to get file content';
}
