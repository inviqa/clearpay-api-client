<?php

namespace spec\Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Api\DataModels\Money;
use PhpSpec\ObjectBehavior;

class MoneySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedFromState([
            'amount'   => '29.99',
            'currency' => 'GBP'
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Money::class);
    }

    function it_has_properties()
    {
        $this->amount()->shouldBe('29.99');
        $this->currency()->shouldBe('GBP');
    }
}
