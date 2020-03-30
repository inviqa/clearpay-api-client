<?php

namespace Inviqa\Clearpay\Exception;


class ServerErrorHttpException extends HttpException
{
    protected function additionalInformation(): string
    {
        return ' - A common cause of this response from PUT/POST endpoints is that the request body is missing or empty.';
    }
}
