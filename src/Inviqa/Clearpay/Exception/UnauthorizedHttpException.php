<?php

namespace Inviqa\Clearpay\Exception;

class UnauthorizedHttpException extends ClientErrorHttpException
{
    protected function additionalInformation(): string
    {
        return 'Invalid Merchant API credentials were passed in the Authorization header.';
    }
}
