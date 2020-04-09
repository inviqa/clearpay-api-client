<?php

namespace spec\Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Api\DataModels\PaymentEvent;
use Inviqa\Clearpay\JsonHandler;
use PhpSpec\ObjectBehavior;

class PaymentEventSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedFromState(
            JsonHandler::decode(
                $this->paymentAuthJson(),
                true
            )
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PaymentEvent::class);
    }

    function it_has_properties()
    {
        $this->id()->shouldBe('1OUR16OTqL3DgJ3ELlwKowU9v6K');
        $this->createdAt()->format('Y-m-d H:i:s')->shouldBe('2019-01-01 00:00:00');
        $this->expiresAt()->format('Y-m-d H:i:s')->shouldBe('2019-01-01 00:00:00');
        $this->type()->shouldBe('AUTH_APPROVED');
        $this->amount()->amount()->shouldBe('100.00');
        $this->amount()->currency()->shouldBe('GBP');
    }

    function it_can_handle_null_expiry_time_for_captured_payments()
    {
        $this->beConstructedFromState(
            JsonHandler::decode(
                $this->paymentVoidedJson(),
                true
            )
        );

        $this->id()->shouldBe('1aGDWRxyqHMzEnBtfLwA0XBAwYQ');
        $this->createdAt()->format('Y-m-d H:i:s')->shouldBe('2020-04-08 13:37:47');
        $this->expiresAt()->shouldBe(null);
        $this->type()->shouldBe('VOIDED');
        $this->amount()->amount()->shouldBe('20.00');
        $this->amount()->currency()->shouldBe('GBP');
    }

    private function paymentAuthJson()
    {
        return <<<JSON
{
  "id" : "1OUR16OTqL3DgJ3ELlwKowU9v6K",
  "created" : "2019-01-01T00:00:00.000Z",
  "expires" : "2019-01-01T00:00:00.000Z",
  "type" : "AUTH_APPROVED",
  "amount" : {
    "amount" : "100.00",
    "currency" : "GBP"
  }
}
JSON;
    }

    private function paymentVoidedJson()
    {
        return <<<JSON
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
JSON;
    }
}
