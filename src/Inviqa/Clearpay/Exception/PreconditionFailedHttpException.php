<?php

namespace Inviqa\Clearpay\Exception;

class PreconditionFailedHttpException extends ClientErrorHttpException
{
    protected function additionalInformation(): string
    {
        // phpcs:disable
        return '';
    }
}

