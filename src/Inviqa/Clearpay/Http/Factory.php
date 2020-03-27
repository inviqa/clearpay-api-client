<?php

namespace Inviqa\Clearpay\Http;

use Inviqa\Clearpay\Http\GuzzleAdapter as HttpClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use GuzzleHttp\Client as Guzzle;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Inviqa\Clearpay\Config;

class Factory
{
    public function create(Config $config): Adapter
    {
        return new HttpClient(
            new GuzzleAdapter(
                new Guzzle([
                    'base_uri' => $config->uri(),
                    'auth'     => [
                        $config->username(),
                        $config->password()
                    ]
                ])
            ),
            new GuzzleMessageFactory()
        );
    }
}
