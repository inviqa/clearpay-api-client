<?php

namespace spec\Inviqa\Clearpay\Http\Response;

use Inviqa\Clearpay\Http\Response\ConfigurationResponse;
use Inviqa\Clearpay\Http\Response\HttpResponse;
use PhpSpec\ObjectBehavior;

class ConfigurationResponseSpec extends ObjectBehavior
{
    function let(HttpResponse $httpResponse) {
        $this->beConstructedWith($httpResponse);
    }

    function it_returns_response_info_when_configuration_json_received(HttpResponse $httpResponse)
    {
        $httpResponse->content()->willReturn('{
                "minimumAmount" : {
                "amount" : "10.00",
                "currency" : "GBP"
            },
                "maximumAmount" : {
                "amount" : "1000.00",
                "currency" : "GBP"
            }
        }');

        $this->isSuccessful()->shouldBe(true);
        $this->getCurrencyCode()->shouldBe("GBP");
        $this->getMinimumAmount()->shouldBe("10.00");
        $this->getMaximumAmount()->shouldBe("1000.00");

    }
}
