<?php

namespace spec\Inviqa\Clearpay\Http;

use Inviqa\Clearpay\Config;
use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\Http\Factory;
use Inviqa\Clearpay\Http\GuzzleAdapter;
use PhpSpec\ObjectBehavior;
use Inviqa\Clearpay\Services\FakeClient;
use Inviqa\Clearpay\Services\TestConfig;

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

    function it_returns_a_fake_client_when_in_test_mode(TestConfig $config)
    {
        $config->isTestMode()->willReturn(true);
        $this->create($config)->shouldBeAnInstanceOf(FakeClient::class);
    }

    function it_returns_a_guzzle_client_when_not_test_mode(Config $config)
    {
        $config->isTestMode()->willReturn(false);
        $result = $this->create($config)->shouldBeAnInstanceOf(GuzzleAdapter::class);

        $config->uri()->shouldHaveBeenCalled();
        $config->username()->shouldHaveBeenCalled();
        $config->password()->shouldHaveBeenCalled();
    }
}
