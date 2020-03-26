<?php

namespace spec\Inviqa\Clearpay\Http;

use Inviqa\Clearpay\Config;
use Inviqa\Clearpay\Http\Factory;
use Inviqa\Clearpay\Http\GuzzleAdapter;
use PhpSpec\ObjectBehavior;

class FactorySpec extends ObjectBehavior
{
    function let(Config $config)
    {
        $config->uri()->willReturn('https://api.eu-sandbox.afterpay.com/v2/');
        $config->username()->willReturn('api-user');
        $config->password()->willReturn('PassW0rd');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Factory::class);
    }

    function it_returns_a_guzzle_client(Config $config)
    {
        $result = $this->create($config)->shouldBeAnInstanceOf(GuzzleAdapter::class);

        $config->uri()->shouldHaveBeenCalled();
        $config->username()->shouldHaveBeenCalled();
        $config->password()->shouldHaveBeenCalled();
    }
}
