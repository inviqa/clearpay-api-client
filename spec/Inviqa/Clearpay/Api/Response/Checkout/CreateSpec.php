<?php

namespace spec\Inviqa\Clearpay\Api\Response\Checkout;

use Inviqa\Clearpay\Api\Response\Checkout\Create;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class CreateSpec extends ObjectBehavior
{
    function let(
        ResponseInterface $response,
        StreamInterface $stream
    )
    {
        $json = <<<JSON
{
  "token" : "003.q49q202qk7ev5ik8camb84u4rrvd23vqp2coav6b5juefrmi",
  "expires" : "2020-03-30T17:55:21.085Z",
  "redirectCheckoutUrl" : "https://portal.sandbox.clearpay.co.uk/uk/checkout/?token=003.q49q202qk7ev5ik8camb84u4rrvd23vqp2coav6b5juefrmi"
}
JSON;

        $stream->getContents()->willReturn($json);
        $response->getBody()->willReturn($stream);

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
}
