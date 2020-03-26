<?php

namespace Inviqa\Clearpay;

use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\Http\Request\ConfigurationProvider;
use Inviqa\Clearpay\Http\Response\ConfigurationResponse;
use Inviqa\Clearpay\Http\Factory;

class Application
{
    /**
     * @var Adapter
     */
    private $client;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var ConfigurationProvider
     */
    private $configurationProvider;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $clientFactory = new Factory();
        $this->client = $clientFactory->create($config);
        $this->configurationProvider = new ConfigurationProvider($this->client, $this->config);
    }

    public function getConfiguration(): ConfigurationResponse
    {
        return $this->configurationProvider->getConfiguration();
    }
}
