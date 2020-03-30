<?php

namespace Inviqa\Clearpay\Exception;


class NotFoundHttpException extends ClientErrorHttpException
{
    protected function additionalInformation(): string
    {
        return 'Has the correct HTTP Method been used? ' . parent::additionalInformation();
    }
}
