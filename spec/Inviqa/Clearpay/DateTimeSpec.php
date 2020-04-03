<?php

namespace spec\Inviqa\Clearpay;

use Inviqa\Clearpay\DateTime;
use PhpSpec\ObjectBehavior;

class DateTimeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DateTime::class);
    }

    function it_can_implement_datetime_interface()
    {
        $this->beConstructedFromTimeString('2020-03-31T18:39:04.425Z');

        $this->asDateTime()
            ->format('Y-m-d H:i:s')
            ->shouldBe('2020-03-31 18:39:04');
    }

    function it_can_handle_utc_offset()
    {
        $this->beConstructedfromTimeString('2019-01-01T00:00:00+10:00');

        $this->asDateTime()
            ->format('Y-m-d H:i:s')
            ->shouldBe('2019-01-01 00:00:00');
    }

    function it_will_fail_with_invalid_time_string()
    {
        $this->beConstructedFromTimeString('');

        $this->asDateTime()->shouldBe(null);
    }
}
