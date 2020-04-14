<?php

namespace spec\Inviqa\Clearpay\Api\Response\Payment;

use Inviqa\Clearpay\Api\DataModels\Payment as PaymentDataModel;
use Inviqa\Clearpay\Api\Response\Payment\Payment;
use Inviqa\Clearpay\Http\Response;
use Inviqa\Clearpay\JsonHandler;
use PhpSpec\ObjectBehavior;

class PaymentSpec extends ObjectBehavior
{
    function let(Response $response)
    {
        $response->asDecodedJson(true)->willReturn(
            $this->decodedJsonResponseBody()
        );

        $this->beConstructedFromHttpResponse($response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Payment::class);
    }

    function it_has_properties()
    {
        $this->payment()->shouldBeAnInstanceOf(PaymentDataModel::class);

        $this->id()->shouldBe('12345678');
        $this->token()->shouldBe('ltqdpjhbqu3veqikk95g7p3fhvcchfvtlsiobah3u4l5nln8gii9');
        $this->merchantReference()->shouldBe('merchantOrderId-1234');

        $this->status()->shouldBe('APPROVED');
        $this->paymentStatusApproved()->shouldBe(true);
        $this->paymentStatusDeclined()->shouldBe(false);

        $this->paymentState()->shouldBe('AUTH_APPROVED');
        $this->paymentStateAuthApproved()->shouldBe(true);
        $this->paymentStateAuthDeclined()->shouldBe(false);
        $this->paymentStatePartiallyCaptured()->shouldBe(false);
        $this->paymentStateCaptured()->shouldBe(false);
        $this->paymentStateCaptureDeclined()->shouldBe(false);
        $this->paymentStateVoided()->shouldBe(false);
    }

    private function decodedJsonResponseBody()
    {
        $json = <<<JSON
{
    "id": "12345678",
    "token": "ltqdpjhbqu3veqikk95g7p3fhvcchfvtlsiobah3u4l5nln8gii9",
    "status": "APPROVED",
    "created": "2019-01-01T00:00:00.000Z",
    "originalAmount": {
        "amount": "100.00",
        "currency": "GBP"
    },
    "openToCaptureAmount": {
        "amount": "100.00",
        "currency": "GBP"
    },
    "paymentState": "AUTH_APPROVED",
    "merchantReference": "merchantOrderId-1234",
    "refunds": [],
    "orderDetails": {
        "consumer": {
            "phoneNumber": "07000000000",
            "givenNames": "Joe",
            "surname": "Consumer",
            "email": "test@example.com"
        }
    },
    "events": [
        {
            "id": "1OUR16OTqL3DgJ3ELlwKowU9v6K",
            "created": "2019-01-01T00:00:00.000Z",
            "expires": "2019-01-01T00:00:00.000Z",
            "type": "AUTH_APPROVED",
            "amount": {
                "amount": "100.00",
                "currency": "GBP"
            }
        }
    ]
}
JSON;

        return JsonHandler::decode($json, true);
    }
}
