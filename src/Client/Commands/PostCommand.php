<?php

namespace Bigcommerce\ORM\Client\Commands;

use Bigcommerce\ORM\Client\LogMessage;

class PostCommand extends AbstractCommand implements CommandInterface
{
    /**
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute()
    {
        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_START, 'POST', $this->apiUrl, json_encode($this->options))
            );
        }

        $result = $this->client->post($this->apiUrl, $this->options);
        if ($this->hasLogger()) {
            $this->logger->debug(
                sprintf(LogMessage::LOG_REQUEST_FINISH, 'POST', $this->apiUrl, json_encode($this->options))
            );
        }

        return $result;
    }
}
