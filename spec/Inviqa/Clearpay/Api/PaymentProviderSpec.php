<?php

namespace spec\Inviqa\Clearpay\Api;

use Inviqa\Clearpay\Api\PaymentProvider;
use Inviqa\Clearpay\Http\Adapter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class PaymentProviderSpec extends ObjectBehavior
{
    function let(
        Adapter $client,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $response->getBody()->willReturn($stream);

        $client->post(
            Argument::any(),
            Argument::any(),
            Argument::any()
        )->willReturn($response);

        $this->beConstructedWith($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PaymentProvider::class);
    }

    function it_can_make_auth_request(
        Adapter $client,
        StreamInterface $stream
    ) {
        $stream->getContents()->willReturn($this->fullJsonAuthResponseBody());

        $requestId = uniqid();
        $token = 'TOKEN';
        $merchantRef = 'ORDER-100';

        $result = $this->auth($token, $requestId, $merchantRef);

        $result->token()->shouldBe('ltqdpjhbqu3veqikk95g7p3fhvcchfvtlsiobah3u4l5nln8gii9');

        $expectedJson = json_encode([
            'requestId'         => $requestId,
            'token'             => $token,
            'merchantReference' => $merchantRef
        ]);

        $client->post(
            'payments/auth',
            [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ],
            $expectedJson
        )->shouldHaveBeenCalled();
    }

    function it_can_make_a_refund_request(
        Adapter $client,
        StreamInterface $stream
    ) {
        $stream
            ->getContents()
            ->willReturn(
                $this->fullJsonRefundResponseBody()
            );

        $orderId = 'clearpay-order-id';
        $requestId = 'request-id';
        $refundAmount = '10.00';
        $refundCurrency = 'GBP';
        $merchantReference = 'merchant-order-ref';
        $merchantRefundRef = 'merchant-refund-ref';

        $this->refund(
            $orderId,
            $refundAmount,
            $refundCurrency,
            $requestId,
            $merchantReference,
            $merchantRefundRef
        );

        $expectedJson = json_encode([
            'requestId'               => $requestId,
            'amount'                  => [
                'amount'   => $refundAmount,
                'currency' => $refundCurrency
            ],
            'merchantReference'       => $merchantReference,
            'refundMerchantReference' => $merchantRefundRef
        ]);

        $client->post(
            'payments/' . $orderId . '/refund',
            [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ],
            $expectedJson
        )->shouldHaveBeenCalled();
    }

    private function fullJsonAuthResponseBody()
    {
        return <<<JSON
{
  "id" : "12345678",
  "token" : "ltqdpjhbqu3veqikk95g7p3fhvcchfvtlsiobah3u4l5nln8gii9",
  "status" : "APPROVED",
  "created" : "2019-01-01T00:00:00.000Z",
  "originalAmount" : {
    "amount" : "100.00",
    "currency" : "GBP"
  },
  "openToCaptureAmount" : {
    "amount" : "100.00",
    "currency" : "GBP"
  },
  "paymentState" : "AUTH_APPROVED",
  "merchantReference" : "merchantOrderId-1234",
  "refunds" : [],
  "orderDetails" : {},
  "events" : [{
    "id" : "1OUR16OTqL3DgJ3ELlwKowU9v6K",
    "created" : "2019-01-01T00:00:00.000Z",
    "expires" : "2019-01-01T00:00:00.000Z",
    "type" : "AUTH_APPROVED",
    "amount" : {
      "amount" : "100.00",
      "currency" : "GBP"
    }
  }]
}
JSON;
    }

    private function fullJsonRefundResponseBody()
    {
        return <<<JSON
{
  "id": "67890123",
  "refundedAt": "2019-01-01T00:00:00.000Z",
  "merchantReference": "merchantRefundId-1234",
  "amount": {
    "amount": "10.00",
    "currency": "GBP"
  }
}
JSON;

    }
}
