<?php

namespace spec\Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Api\DataModels\Consumer;
use Inviqa\Clearpay\JsonHandler;
use PhpSpec\ObjectBehavior;

class ConsumerSpec extends ObjectBehavior
{
    function let()
    {
        $json = <<<JSON
{
  "phoneNumber": "07000000000",
  "givenNames": "Joe",
  "surname": "Consumer",
  "email": "test@example.com"
}
JSON;

        $this->beConstructedFromState(JsonHandler::decode($json, true));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Consumer::class);
    }

    function it_has_properties()
    {
        $this->givenNames()->shouldBe('Joe');
        $this->surname()->shouldBe('Consumer');
        $this->phoneNumber()->shouldBe('07000000000');
        $this->email()->shouldBe('test@example.com');
    }
}
