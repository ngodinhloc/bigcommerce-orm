<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

/**
 * Class LogMessage
 * @package Bigcommerce\ORM\Client
 */
class LogMessage
{
    const LOG_REQUEST_START = 'Start request. Method: %s. Url: %s. Request options: %s';
    const LOG_REQUEST_FINISH = 'Finish request. Method: %s. Url: %s. Request options: %s';
}
