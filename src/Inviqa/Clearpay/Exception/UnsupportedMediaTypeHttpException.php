<?php

namespace Inviqa\Clearpay\Exception;


class UnsupportedMediaTypeHttpException extends ClientErrorHttpException
{
    protected function additionalInformation(): string
    {
         return <<<STRING
- The request did not include a Content-Type header, or its value was anything other than application/json. see (https://clearpay-online.readme.io/v2/reference#put-post-errors)
STRING;
    }
}
