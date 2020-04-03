<?php

namespace spec\Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Api\DataModels\PaymentEvent;
use Inviqa\Clearpay\JsonHandler;
use PhpSpec\ObjectBehavior;

class PaymentEventSpec extends ObjectBehavior
{
    function let()
    {
        $json = <<<JSON
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

        $this->beConstructedFromState(JsonHandler::decode($json, true));
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
}
