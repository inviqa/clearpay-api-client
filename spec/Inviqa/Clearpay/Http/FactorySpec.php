<?php

namespace spec\Inviqa\Clearpay\Http;

use Inviqa\Clearpay\Config;
use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\Http\Factory;
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

    function it_can_create_http_adapter(Config $config)
    {
        $result = $this::create($config);

        $result->shouldImplement(Adapter::class);

        $config->uri()->shouldHaveBeenCalled();
        $config->username()->shouldHaveBeenCalled();
        $config->password()->shouldHaveBeenCalled();
    }
}
