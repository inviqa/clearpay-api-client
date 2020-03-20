<?php

namespace spec\Inviqa\Clearpay\Http;

use GuzzleHttp\Client;
use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\Http\GuzzleAdapter;
use PhpSpec\ObjectBehavior;

class GuzzleAdapterSpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client);
    }

    function it_is_initializable(Client $client)
    {
        $this->shouldHaveType(GuzzleAdapter::class);
        $this->shouldImplement(Adapter::class);
    }

    function it_can_make_http_get_request(Client $client)
    {
        $this->get('/configuration', []);

        $client->get('/configuration', [])->shouldHaveBeenCalled();
    }

    function it_can_make_http_post_request(Client $client)
    {
        $this->post('/configuration', ['json' => ['foo' => 'bar']]);

        $client->post('/configuration', ['json' => ['foo' => 'bar']])->shouldHaveBeenCalled();
    }


}
