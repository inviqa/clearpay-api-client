<?php

namespace Inviqa\Clearpay\Http;

use GuzzleHttp\Client;
use Inviqa\Clearpay\Config;

class Factory
{
    public static function create(Config $config) : Adapter
    {
        return new GuzzleAdapter(
            new Client([
                'base_uri' => $config->uri(),
                'auth'     => [
                    $config->username(),
                    $config->password()
                ]
            ])
        );
    }
}
