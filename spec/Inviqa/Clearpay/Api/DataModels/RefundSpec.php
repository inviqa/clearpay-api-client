<?php

namespace spec\Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Api\DataModels\Refund;
use Inviqa\Clearpay\JsonHandler;
use PhpSpec\ObjectBehavior;

class RefundSpec extends ObjectBehavior
{
    function let()
    {
        $json = <<<JSON
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
        $this->beConstructedFromState(JsonHandler::decode($json, true));

    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Refund::class);
    }

    function it_has_properties()
    {
        $this->id()->shouldBe('67890123');
        $this->refundedAt()->format('Y-m-d H:i:s')->shouldBe('2019-01-01 00:00:00');
        $this->merchantReference()->shouldBe('merchantRefundId-1234');
        $this->amount()->amount()->shouldBe('10.00');
        $this->amount()->currency()->shouldBe('GBP');
    }
}
