<?php

namespace spec\Inviqa\Clearpay\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\Http\GuzzleAdapter;
use Inviqa\Clearpay\Http\Response\HttpResponse;
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

    function it_can_make_http_get_request(Client $client, Response $response, Stream $stream)
    {
        $client->get('/configuration', [])->willReturn($response);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn('{
                "minimumAmount" : {
                "amount" : "10.00",
                "currency" : "GBP"
            },
                "maximumAmount" : {
                "amount" : "1000.00",
                "currency" : "GBP"
            }
        }');
        $this->get('/configuration', [])->shouldBeAnInstanceOf(HttpResponse::class);

    }

    function it_can_make_http_post_request(Client $client)
    {
        $this->post('/configuration', ['json' => ['foo' => 'bar']]);

        $client->post('/configuration', ['json' => ['foo' => 'bar']])->shouldHaveBeenCalled();
    }


}
