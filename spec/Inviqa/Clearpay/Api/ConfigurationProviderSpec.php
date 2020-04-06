<?php

namespace spec\Inviqa\Clearpay\Api;

use Inviqa\Clearpay\Api\Response\ConfigurationResponse;
use Inviqa\Clearpay\Http\Adapter;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ConfigurationProviderSpec extends ObjectBehavior
{
    function let(
        Adapter $client,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $stream->getContents()->willReturn(
            $this->fullResponseBodyJson()
        );
        $response->getBody()->willReturn($stream);
        $client->get('configuration')->willReturn($response);

        $this->beConstructedWith($client);
    }

    function it_has_configuration_response()
    {
        $result = $this->getConfiguration();

        $result->shouldBeAnInstanceOf(ConfigurationResponse::class);

        $result->getCurrencyCode()->shouldBe('GBP');
        $result->getMinimumAmount()->shouldBe('10.00');
        $result->getMaximumAmount()->shouldBe('1000.00');
    }

    private function fullResponseBodyJson()
    {
        return <<<JSON
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
    }
}
