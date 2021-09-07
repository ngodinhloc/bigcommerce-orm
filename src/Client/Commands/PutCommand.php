<?php

namespace Bigcommerce\ORM\Client\Commands;

use Bigcommerce\ORM\Client\LogMessage;

class PutCommand extends AbstractCommand implements CommandInterface
{
    /**
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute()
    {
        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_START, 'PUT', $this->apiUrl, json_encode($this->options))
            );
        }

        $result = $this->client->put($this->apiUrl, $this->options);
        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_FINISH, 'PUT', $this->apiUrl, json_encode($this->options))
            );
        }

        return $result;
    }
}
