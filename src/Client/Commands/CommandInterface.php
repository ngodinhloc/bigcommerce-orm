<?php

namespace Bigcommerce\ORM\Client\Commands;

interface CommandInterface
{
    /**
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute();
}
