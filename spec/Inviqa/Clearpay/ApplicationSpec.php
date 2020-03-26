<?php

namespace spec\Inviqa\Clearpay;

use Inviqa\Clearpay\Application;
use Inviqa\Clearpay\Config;
use Inviqa\Clearpay\Services\TestConfig;
use PhpSpec\ObjectBehavior;

class ApplicationSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new TestConfig('user', 'secret'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Application::class);
    }

    function it_can_create_checkout()
    {
        $this->createCheckout([])->shouldBe(true);
    }
}
