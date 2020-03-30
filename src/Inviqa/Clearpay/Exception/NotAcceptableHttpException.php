<?php

namespace Inviqa\Clearpay\Exception;

class NotAcceptableHttpException extends ClientErrorHttpException
{
    protected function additionalInformation(): string
    {
        return ' - The request included an Accept header for something other than application/json or */*.';
    }
}
