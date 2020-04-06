<?php

namespace spec\Inviqa\Clearpay\Api\Response;

use Inviqa\Clearpay\Http\Response;
use PhpSpec\ObjectBehavior;

class ConfigurationResponseSpec extends ObjectBehavior
{
    function let(Response $response)
    {
        $this->beConstructedFromHttpResponse($response);
    }

    function it_has_full_json_response(
        Response $response
    ) {
        $response->asDecodedJson(true)->willReturn(
            $this->fullJsonResponse()
        );

        $this->getCurrencyCode()->shouldBe("GBP");
        $this->getMinimumAmount()->shouldBe("10.00");
        $this->getMaximumAmount()->shouldBe("1000.00");
    }

    function it_has_partial_json_response(
        Response $response
    ) {
        $response->asDecodedJson(true)->willReturn(
            $this->partialJsonResponse()
        );

        $this->getCurrencyCode()->shouldBe("GBP");
        $this->getMinimumAmount()->shouldBe("0.00");
        $this->getMaximumAmount()->shouldBe("500.00");
    }

    private function fullJsonResponse()
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

    private function partialJsonResponse()
    {
        $json = <<<JSON
{
    "maximumAmount" : {
        "amount" : "500.00",
        "currency" : "GBP"
    }
}
JSON;
        return json_decode($json, true);
    }
}
