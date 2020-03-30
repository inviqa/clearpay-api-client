<?php

namespace Inviqa\Clearpay\Exception;


class MethodNotAllowedHttpException extends ClientErrorHttpException
{
    protected function additionalInformation(): string
    {
        return ' - The request was made using an unacceptable HTTP Method. See (https://clearpay-online.readme.io/v2/reference#put-post-errors)';
    }
}
