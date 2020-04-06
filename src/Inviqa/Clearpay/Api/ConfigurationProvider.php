<?php

namespace Inviqa\Clearpay\Api;

use Inviqa\Clearpay\Api\Response\ConfigurationResponse;
use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\Http\Response;

class ConfigurationProvider
{
    /**
     * @var Adapter
     */
    private $client;

    public function __construct(Adapter $client)
    {
        $this->client = $client;
    }

    public function getConfiguration(): ConfigurationResponse
    {
        return ConfigurationResponse::fromHttpResponse(
            Response::fromHttpResponse(
                $this->client->get('configuration')
            )
        );
    }
}
