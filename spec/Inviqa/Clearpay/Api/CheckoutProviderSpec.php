<?php

namespace spec\Inviqa\Clearpay\Api;

use Inviqa\Clearpay\Api\CheckoutProvider;
use Inviqa\Clearpay\Api\Response\Checkout\Create;
use Inviqa\Clearpay\Http\Adapter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class CheckoutProviderSpec extends ObjectBehavior
{
    function let(
        Adapter $adapter,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $json = <<<JSON
{
  "token" : "003.q49q202qk7ev5ik8camb84u4rrvd23vqp2coav6b5juefrmi",
  "expires" : "2020-03-30T17:55:21.085Z",
  "redirectCheckoutUrl" : "https://portal.sandbox.clearpay.co.uk/uk/checkout/?token=003.q49q202qk7ev5ik8camb84u4rrvd23vqp2coav6b5juefrmi"
}
JSON;
        $stream->getContents()->willReturn($json);
        $response->getBody()->willReturn($stream);

        $adapter->post(
            Argument::any(),
            Argument::any(),
            Argument::any()
        )->willReturn($response);

        $this->beConstructedWith($adapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CheckoutProvider::class);
    }

    function it_can_create_a_new_checkout(
        Adapter $adapter
    ) {
        $this->createCheckout(
            $this->default_params()
        )->shouldBeAnInstanceOf(Create::class);

        $adapter->post(
            'checkouts',
            [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ],
            json_encode($this->default_params())
        )->shouldHaveBeenCalled();
    }

    private function default_params()
    {
        return [
            'amount'   => [
                'amount'   => '30.00',
                'currency' => 'GBP'
            ],
            'consumer' => [
                'phoneNumber' => '0123456789',
                'givenNames'  => 'Testy',
                'surname'     => 'testerson',
                'email'       => 'name@example.com'
            ],
            'merchant' => [
                'redirectConfirmUrl' => 'https://example.com/checkout/confirm',
                'redirectCancelUrl'  => 'https://example.com/checkout/cancel',
            ]
        ];
    }
}
