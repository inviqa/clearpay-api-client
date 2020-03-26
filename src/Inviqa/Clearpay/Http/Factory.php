<?php

namespace Inviqa\Clearpay\Http;

use GuzzleHttp\Client;
use Inviqa\Clearpay\Config;
use Inviqa\Clearpay\Services\FakeClient;

class Factory
{
    public function create(Config $config) : Adapter
    {
        if ($config->isTestMode()) {
            return new FakeClient();
        }

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
