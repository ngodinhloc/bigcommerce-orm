<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Client;

class ResponseCodes
{
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NO_CONTENT = 204;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_SERVER_ERROR = 500;
}
