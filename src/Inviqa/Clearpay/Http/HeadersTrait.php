<?php

namespace Inviqa\Clearpay\Http;

trait HeadersTrait
{
    public function defaultPostHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json'
        ];
    }
}
