<?php

namespace spec\Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Api\DataModels\Contact;
use PhpSpec\ObjectBehavior;

class ContactSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedFromState(
            $this->fullContactState()
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Contact::class);
    }

    function it_has_full_properties()
    {
        $this->name()->shouldBe('Joe Consumer');
        $this->line1()->shouldBe('1 Market Street');
        $this->line2()->shouldBe('line2');
        $this->area1()->shouldBe('area1');
        $this->area2()->shouldBe('area2');
        $this->region()->shouldBe('MANCHESTER');
        $this->postcode()->shouldBe('M4 3AT');
        $this->countryCode()->shouldBe('GB');
        $this->phoneNumber()->shouldBe('07000000000');
    }

    function it_has_minimal_properties()
    {
        $this->beConstructedFromState([
            "name"        => "Joe Consumer",
            "line1"       => "1 Market Street",
            "region"      => "MANCHESTER",
            "postcode"    => "M4 3AT",
            "countryCode" => "GB",
            "phoneNumber" => "07000000000"
        ]);

        $this->name()->shouldBe('Joe Consumer');
        $this->line1()->shouldBe('1 Market Street');
        $this->line2()->shouldBe('');
        $this->area1()->shouldBe('');
        $this->area2()->shouldBe('');
        $this->region()->shouldBe('MANCHESTER');
        $this->postcode()->shouldBe('M4 3AT');
        $this->countryCode()->shouldBe('GB');
        $this->phoneNumber()->shouldBe('07000000000');
    }

    function it_has_empty_properties_for_order_detail_billing_contact()
    {
        $this->beConstructedFromState([]);

        $this->name()->shouldBe('');
        $this->line1()->shouldBe('');
        $this->line2()->shouldBe('');
        $this->area1()->shouldBe('');
        $this->area2()->shouldBe('');
        $this->region()->shouldBe('');
        $this->postcode()->shouldBe('');
        $this->countryCode()->shouldBe('');
        $this->phoneNumber()->shouldBe('');
    }

    private function fullContactState()
    {
        return [
            "name"        => "Joe Consumer",
            "line1"       => "1 Market Street",
            "line2"       => "line2",
            "area1"       => "area1",
            "area2"       => "area2",
            "region"      => "MANCHESTER",
            "postcode"    => "M4 3AT",
            "countryCode" => "GB",
            "phoneNumber" => "07000000000"
        ];
    }
}
