<?php

namespace spec\Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Api\DataModels\ShippingCourier;
use PhpSpec\ObjectBehavior;

class ShippingCourierSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ShippingCourier::class);
    }

    function it_has_full_properties()
    {
        $this->beConstructedFromState([
            "shippedAt" => "2019-01-01T00:00:00+10:00",
            "name"      => "Parcelforce Worldwide",
            "tracking"  => "AAAA1234567890",
            "priority"  => "STANDARD"
        ]);

        $this->shippedAt()->format('Y-m-d H:i:s')->shouldBe('2019-01-01 00:00:00');
        $this->name()->shouldBe('Parcelforce Worldwide');
        $this->tracking()->shouldBe('AAAA1234567890');
        $this->priority()->shouldBe('STANDARD');
    }

    function it_has_empty_properties()
    {
        $this->beConstructedFromState([
            "shippedAt" => '',
            "name"      => '',
            "tracking"  => '',
            "priority"  => ''
        ]);

        $this->shippedAt()->shouldBe(null);
        $this->name()->shouldBe('');
        $this->tracking()->shouldBe('');
        $this->priority()->shouldBe('');
    }
}
