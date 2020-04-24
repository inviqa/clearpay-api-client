<?php

namespace spec\Inviqa\Clearpay\Api\Response\Checkout;

use Inviqa\Clearpay\Api\Response\Checkout\Create;
use Inviqa\Clearpay\Http\Response;
use Inviqa\Clearpay\JsonHandler;
use PhpSpec\ObjectBehavior;

class CreateSpec extends ObjectBehavior
{
    function let(Response $response)
    {
        $response->asDecodedJson(true)->willReturn(
            $this->decodedJsonResponse()
        );

        $this->beConstructedFromHttpResponse($response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Create::class);
    }

    function it_has_attributes()
    {
        $this->token()->shouldBe('003.q49q202qk7ev5ik8camb84u4rrvd23vqp2coav6b5juefrmi');
        $this->redirectCheckoutUrl()->shouldBe('https://portal.sandbox.clearpay.co.uk/uk/checkout/?token=003.q49q202qk7ev5ik8camb84u4rrvd23vqp2coav6b5juefrmi');
        $this->expires()->shouldBeAnInstanceOf(\DateTimeInterface::class);
    }

    function it_has_correct_expires_time()
    {
        $this->expires()
            ->format('Y-m-d H:i:s')
            ->shouldBe('2020-03-30 17:55:21');
    }

    function it_can_be_represented_as_array()
    {
        $this->toArray()->shouldBe($this->decodedJsonResponse());
    }

    private function decodedJsonResponse()
    {
        $json = <<<JSON
{
  "token" : "003.q49q202qk7ev5ik8camb84u4rrvd23vqp2coav6b5juefrmi",
  "expires" : "2020-03-30T17:55:21.085Z",
  "redirectCheckoutUrl" : "https://portal.sandbox.clearpay.co.uk/uk/checkout/?token=003.q49q202qk7ev5ik8camb84u4rrvd23vqp2coav6b5juefrmi"
}
JSON;

        return JsonHandler::decode($json, true);
    }
}
