<?php

namespace spec\Inviqa\Clearpay\Api\Response;

use Inviqa\Clearpay\Http\Response;
use PhpSpec\ObjectBehavior;

class ConfigurationResponseSpec extends ObjectBehavior
{
    function let(Response $response)
    {
        $this->beConstructedWith($response);
    }

    function it_returns_response_info_when_configuration_json_received(
        Response $response
    ) {
        $response->asDecodedJson(true)->willReturn($this->data());

        $this->isSuccessful()->shouldBe(true);
        $this->getCurrencyCode()->shouldBe("GBP");
        $this->getMinimumAmount()->shouldBe("10.00");
        $this->getMaximumAmount()->shouldBe("1000.00");
    }

    private function data()
    {
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

        return json_decode($json, true);
    }
}
