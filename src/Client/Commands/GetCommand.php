<?php

namespace Bigcommerce\ORM\Client\Commands;

use Bigcommerce\ORM\Client\LogMessage;

class GetCommand extends AbstractCommand implements CommandInterface
{
    /**
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute()
    {
        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_START, 'GET', $this->apiUrl, json_encode($this->options))
            );
        }

        $result = $this->client->get($this->apiUrl, $this->options);
        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_FINISH, 'GET', $this->apiUrl, json_encode($this->options))
            );
        }

        return $result;
    }
}
