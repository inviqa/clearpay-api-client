<?php

namespace Inviqa\Clearpay\Http\Request;

use Inviqa\Clearpay\Config;
use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\Http\Response\ConfigurationResponse;

class ConfigurationProvider
{
    const CONFIG_URI = 'configuration';

    /**
     * @var Adapter
     */
    private $client;
    /**
     * @var Config
     */
    private $config;

    public function __construct(Adapter $client, Config $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function getConfiguration(): ConfigurationResponse
    {
        return new ConfigurationResponse($this->client->get($this->config->uri() . self::CONFIG_URI));
    }
}
