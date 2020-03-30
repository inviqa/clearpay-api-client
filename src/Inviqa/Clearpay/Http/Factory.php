<?php

namespace Inviqa\Clearpay\Http;

use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use GuzzleHttp\Client as Guzzle;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Inviqa\Clearpay\Config;

class Factory
{
    public function create(Config $config): Adapter
    {
        return new Client(
            new GuzzleAdapter(
                new Guzzle([
                    'base_uri'    => $config->uri(),
                    'auth'        => [
                        $config->username(),
                        $config->password()
                    ],
                    'http_errors' => false
                ])
            ),
            new GuzzleMessageFactory()
        );
    }
}
