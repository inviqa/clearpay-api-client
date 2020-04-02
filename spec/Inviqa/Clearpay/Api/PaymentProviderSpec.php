<?php

namespace spec\Inviqa\Clearpay\Api;

use Inviqa\Clearpay\Api\PaymentProvider;
use Inviqa\Clearpay\Http\Adapter;
use PhpSpec\ObjectBehavior;

class PaymentProviderSpec extends ObjectBehavior
{
    function let(Adapter $client)
    {
        $this->beConstructedWith($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PaymentProvider::class);
    }

    function it_can_make_auth_request(
        Adapter $client
    ) {
        $requestId = uniqid();
        $params = [
            'requestId'         => $requestId,
            'token'             => 'TOKEN',
            'merchantReference' => 'ORDER-100'
        ];

        $this->auth($params);

        $expectedJson = json_encode($params);

        $client->post(
            'payments/auth',
            [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ],
            $expectedJson
        )->shouldHaveBeenCalled();
    }
}
