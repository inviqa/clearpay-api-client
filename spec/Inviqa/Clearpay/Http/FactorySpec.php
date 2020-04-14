<?php

namespace spec\Inviqa\Clearpay\Http;

use Inviqa\Clearpay\Config;
use Inviqa\Clearpay\Http\Factory;
use Inviqa\Clearpay\Http\Client;
use PhpSpec\ObjectBehavior;

class FactorySpec extends ObjectBehavior
{
    function let(Config $config)
    {
        $config->uri()->willReturn('https://api.eu-sandbox.afterpay.com/v2/');
        $config->username()->willReturn('api-user');
        $config->password()->willReturn('PassW0rd');
        $config->userAgent()->willReturn('phpspec');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Factory::class);
    }

    function it_returns_a_guzzle_client(Config $config)
    {
        $this::create($config)->shouldBeAnInstanceOf(Client::class);

        $config->uri()->shouldHaveBeenCalled();
        $config->username()->shouldHaveBeenCalled();
        $config->password()->shouldHaveBeenCalled();
        $config->userAgent()->shouldHaveBeenCalled();
    }
}
