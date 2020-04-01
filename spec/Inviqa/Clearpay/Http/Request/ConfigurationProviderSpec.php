<?php

namespace spec\Inviqa\Clearpay\Http\Request;

use Inviqa\Clearpay\Config;
use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\Http\Response\ConfigurationResponse;
use Inviqa\Clearpay\Http\Response\HttpResponse;
use PhpSpec\ObjectBehavior;

class ConfigurationProviderSpec extends ObjectBehavior
{
    function let(Adapter $client, Config $config)
    {
        $this->beConstructedWith($client, $config);
    }

    function it_gets_successful_configuration_response(
        Adapter $client,
        Config $config,
        HttpResponse $httpResponse
    ) {
        $json = <<<JSON
{
  "minimumAmount" : {
    "amount" : "10.00",
    "currency" : "GBP"
  },
  "maximumAmount" : {
    "amount" : "1000.00",
    "currency" : "GBP"
  }
}
JSON;

        $httpResponse->content()->willReturn($json);

        $config->uri()->willReturn('https://api.eu-sandbox.afterpay.com/v2/');
        $client->get('https://api.eu-sandbox.afterpay.com/v2/configuration')
            ->willReturn($httpResponse);

        $this->getConfiguration($client, $config)
            ->shouldBeAnInstanceOf(ConfigurationResponse::class);
    }
}
