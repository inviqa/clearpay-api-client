<?php

namespace spec\Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Api\DataModels\Discount;
use PhpSpec\ObjectBehavior;

class DiscountSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedFromState([
            "displayName" => "New Customer Coupon",
            "amount"      => [
                "amount"   => "29.99",
                "currency" => "GBP"
            ]
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Discount::class);
    }

    function it_has_properties()
    {
        $this->displayName()->shouldBe('New Customer Coupon');
        $this->amount()->amount()->shouldBe('29.99');
        $this->amount()->currency()->shouldBe('GBP');
    }
}
