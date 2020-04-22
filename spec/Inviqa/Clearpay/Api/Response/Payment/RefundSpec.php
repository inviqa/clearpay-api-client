<?php

namespace spec\Inviqa\Clearpay\Api\Response\Payment;

use Inviqa\Clearpay\Api\Response\Payment\Refund;
use Inviqa\Clearpay\Http\Response;
use Inviqa\Clearpay\JsonHandler;
use PhpSpec\ObjectBehavior;

class RefundSpec extends ObjectBehavior
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
        $this->shouldHaveType(Refund::class);
    }

    function it_has_refund_data_model_properties()
    {
        $this->refundId()->shouldBe('67890123');
        $this->refundedAt()
            ->format('Y-m-d H:i:s')
            ->shouldBe('2019-01-01 00:00:00');

        $this->merchantReference()->shouldBe('merchantRefundId-1234');
        $this->amount()->amount()->shouldBe('10.00');
        $this->amount()->currency()->shouldBe('GBP');
    }

    private function decodedJsonResponseBody()
    {
        $json = <<<JSON
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

        return JsonHandler::decode($json, true);
    }
}
