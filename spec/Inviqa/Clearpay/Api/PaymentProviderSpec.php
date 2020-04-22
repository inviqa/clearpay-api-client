<?php

namespace spec\Inviqa\Clearpay\Api;

use Inviqa\Clearpay\Api\PaymentProvider;
use Inviqa\Clearpay\Api\Response\Payment\Payment;
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
        $stream->getContents()->willReturn($this->fullJsonPaymentResponseBody());

        $requestId = uniqid();
        $token = 'TOKEN';
        $merchantRef = 'ORDER-100';

        $result = $this->auth($token, $requestId, $merchantRef);

        $result->shouldBeAnInstanceOf(Payment::class);

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

    function it_can_make_a_capture_request(
        Adapter $client,
        StreamInterface $stream
    ) {
        $stream
            ->getContents()
            ->willReturn(
                $this->fullJsonPaymentResponseBody()
            );

        $orderId = 'clearpay-order-id';
        $requestId = 'request-id';
        $captureAmount = '10.00';
        $captureCurrency = 'GBP';
        $merchantReference = 'merchant-order-ref';
        $paymentEventMerchantReference = 'merchant-payment-ref';

        $this->capture(
            $orderId,
            $captureAmount,
            $captureCurrency,
            $requestId,
            $merchantReference,
            $paymentEventMerchantReference
        );

        $expectedJson = json_encode([
            'requestId'                     => $requestId,
            'amount'                        => [
                'amount'   => $captureAmount,
                'currency' => $captureCurrency
            ],
            'merchantReference'             => $merchantReference,
            'paymentEventMerchantReference' => $paymentEventMerchantReference
        ]);

        $client->post(
            'payments/' . $orderId . '/capture',
            [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ],
            $expectedJson
        )->shouldHaveBeenCalled();
    }

    function it_can_make_a_void_request(
        Adapter $client,
        StreamInterface $stream
    ) {
        $stream
            ->getContents()
            ->willReturn(
                $this->fullJsonPaymentResponseBody()
            );

        $orderId = '123456789';

        $this->void($orderId);

        $client->post(
            'payments/' . $orderId . '/void',
            [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ],
            null
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

    private function fullJsonPaymentResponseBody()
    {
        return <<<JSON
{
    "id": "400123851519",
    "token": "003.gdekaou4h9e4nnkf1ejjip26ghmi9aeflhchg7oi9nddc771",
    "status": "APPROVED",
    "created": "2020-04-08T09:44:33.231Z",
    "originalAmount": {
        "amount": "30.00",
        "currency": "GBP"
    },
    "openToCaptureAmount": {
        "amount": "0.00",
        "currency": "GBP"
    },
    "paymentState": "CAPTURED",
    "merchantReference": "ref-5e8d9ce279fdd",
    "refunds": [
        {
            "amount": {
                "amount": "20.00",
                "currency": "GBP"
            },
            "refundId": "3221",
            "refundedAt": "2020-04-08T13:37:46.639Z"
        }
    ],
    "orderDetails": {
        "consumer": {
            "phoneNumber": "07855782357",
            "givenNames": "Testy",
            "surname": "Testerson",
            "email": "bmcmanus+clearpay-customer@inviqa.com"
        },
        "courier": {},
        "items": [],
        "discounts": []
    },
    "events": [
        {
            "id": "1aFls8coGVgpTC9QvrK6mpnjaH8",
            "created": "2020-04-08T09:50:26.135Z",
            "expires": "2020-04-09T21:50:26.135Z",
            "type": "AUTH_APPROVED",
            "amount": {
                "amount": "30.00",
                "currency": "GBP"
            },
            "paymentEventMerchantReference": null
        },
        {
            "id": "1aGDMrB7wL2rrc27joIIcNdEFRV",
            "created": "2020-04-08T13:36:31.139Z",
            "expires": null,
            "type": "CAPTURED",
            "amount": {
                "amount": "10.00",
                "currency": "GBP"
            },
            "paymentEventMerchantReference": null
        },
        {
            "id": "1aGDWRxyqHMzEnBtfLwA0XBAwYQ",
            "created": "2020-04-08T13:37:47.222Z",
            "expires": null,
            "type": "VOIDED",
            "amount": {
                "amount": "20.00",
                "currency": "GBP"
            },
            "paymentEventMerchantReference": null
        }
    ]
}
JSON;
    }

    private function fullJsonRefundResponseBody()
    {
        return <<<JSON
{
  "refundId": "67890123",
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
