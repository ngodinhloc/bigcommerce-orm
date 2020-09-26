<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

/**
 * Class LogMessage
 * @package Bigcommerce\ORM\Client
 */
class LogMessage
{
    const LOG_QUERY_START = 'Start querying objects. Resource type: %s. Query: %s';
    const LOG_QUERY_FINISH = 'Finish querying objects. Resource type: %s. Query: %s';
    const LOG_UPDATE_START = 'Start updating objects. Resource type: %s. Path: %s .Data: %s';
    const LOG_UPDATE_FINISH = 'Finish updating objects. Resource type: %s. Path: %s .Data: %s';
    const LOG_CREATE_START = 'Start creating objects. Resource type: %s. Path: %s. Data: %s';
    const LOG_CREATE_FINISH = 'Finish creating objects. Resource type: %s. Path: %s. Data: %s';
    const LOG_DELETE_START = 'Start deleting objects. Resource type: %s. Query: %s';
    const LOG_DELETE_FINISH = 'Finish deleting objects. Resource type: %s. Query: %s';
}
