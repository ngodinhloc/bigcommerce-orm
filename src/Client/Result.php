<?php

namespace Bigcommerce\ORM\Client;

use Bigcommerce\ORM\Client\Exceptions\ResultException;
use Psr\Http\Message\ResponseInterface;

class Result
{
    const RETURN_TYPE_FIRST = 'first';
    const RETURN_TYPE_ONE = 'one';
    const RETURN_TYPE_COUNT = 'count';
    const RETURN_TYPE_ALL = 'all';
    const RETURN_TYPE_BOOL = "bool";

    /* @var \Psr\Http\Message\ResponseInterface|null */
    protected $response;

    /**
     * Result constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface|null $response response
     */
    public function __construct(ResponseInterface $response = null)
    {
        $this->response = $response;
    }

    /**
     * @param string|null $returnType
     * @return array|int|bool
     * @throws \Bigcommerce\ORM\Client\Exceptions\ResultException
     */
    public function get(string $returnType = null)
    {
        if (!$this->response) {
            throw new ResultException(ResultException::ERROR_NO_RESPONSE_PROVIDED);
        }

        $result = false;
        switch ($this->response->getStatusCode()) {
            case ResponseCodes::HTTP_OK:
                if ($content = $this->response->getBody()->getContents()) {
                    $array = json_decode($content, true);
                    switch ($returnType) {
                        case self::RETURN_TYPE_BOOL:
                            return true;
                        case self::RETURN_TYPE_COUNT:
                            return count($array['data']);
                        case self::RETURN_TYPE_FIRST:
                            return $array['data'][0];
                        case self::RETURN_TYPE_ONE:
                        case self::RETURN_TYPE_ALL:
                        default:
                            return $array['data'];
                    }
                }
                break;
            case ResponseCodes::HTTP_NO_CONTENT:
                /** delete entities return 204 */
                return true;
        }

        return $result;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface|null $response response
     * @return \Bigcommerce\ORM\Client\Result
     */
    public function setResponse(ResponseInterface $response = null)
    {
        $this->response = $response;

        return $this;
    }
}
