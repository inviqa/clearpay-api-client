<?php

namespace spec\Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Api\DataModels\Payment;
use Inviqa\Clearpay\JsonHandler;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class PaymentSpec extends ObjectBehavior
{
    function let()
    {
        $state = JsonHandler::decode($this->fullJsonHttpResponseBody(), true);

        $this->beConstructedFromState($state);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Payment::class);
    }

    function it_has_properties()
    {
        $this->id()->shouldBe('12345678');
        $this->token()->shouldBe('ltqdpjhbqu3veqikk95g7p3fhvcchfvtlsiobah3u4l5nln8gii9');
        $this->status()->shouldBe('APPROVED');
        $this->paymentState()->shouldBe('AUTH_APPROVED');

        $this->merchantReference()->shouldBe('merchantOrderId-1234');

        $this->createdAt()
            ->format('Y-m-d H:i:s')
            ->shouldBe('2019-01-01 00:00:00');

        $this->originalAmount()->amount()->shouldBe('100.00');
        $this->originalAmount()->currency()->shouldBe('GBP');

        $this->openToCaptureAmount()->amount()->shouldBe('100.00');
        $this->openToCaptureAmount()->currency()->shouldBe('GBP');
    }

    private function fullJsonHttpResponseBody()
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
}
