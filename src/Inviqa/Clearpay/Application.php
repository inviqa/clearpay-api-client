<?php

namespace Inviqa\Clearpay;

use Inviqa\Clearpay\Api\Response\Checkout\Create;
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

    public function __construct(
        Config $config,
        ?Adapter $client = null
    ) {
        $this->config = $config;
        $this->client = $client ?: Factory::create($config);
        $this->configurationProvider = new ConfigurationProvider($this->client, $this->config);
    }

    public function getConfiguration(): ConfigurationResponse
    {
        return $this->configurationProvider->getConfiguration();
    }

    public function createCheckout(array $params = []): Create
    {
        return (new Api\CheckoutProvider($this->client))->createCheckout($params);
    }
}
