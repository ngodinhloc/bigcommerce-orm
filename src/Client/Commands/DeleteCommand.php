<?php

namespace Bigcommerce\ORM\Client\Commands;

use Bigcommerce\ORM\Client\LogMessage;

class DeleteCommand extends AbstractCommand implements CommandInterface
{
    /**
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute()
    {
        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_START, 'DELETE', $this->apiUrl, json_encode($this->options))
            );
        }

        $result = $this->client->delete($this->apiUrl, $this->options);
        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_FINISH, 'DELETE', $this->apiUrl, json_encode($this->options))
            );
        }

        return $result;
    }
}
