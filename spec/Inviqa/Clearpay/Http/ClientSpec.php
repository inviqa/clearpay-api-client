<?php

namespace spec\Inviqa\Clearpay\Http;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\Http\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ClientSpec extends ObjectBehavior
{
    function let(
        HttpClient $httpClient,
        RequestFactory $requestFactory,
        RequestInterface $request,
        StreamInterface $body,
        ResponseInterface $response
    ) {
        $requestFactory->createRequest(
            Argument::any(),
            Argument::any(),
            [],
            Argument::any()
        )->willReturn($request);

        $body->getContents()->willReturn('');

        $response->getBody()->willReturn($body);

        $httpClient->sendRequest(Argument::type(RequestInterface::class))
            ->willReturn($response);

        $this->beConstructedWith($httpClient, $requestFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Client::class);
        $this->shouldImplement(Adapter::class);
    }

    function it_can_make_http_get_request(
        HttpClient $httpClient,
        RequestFactory $requestFactory,
        RequestInterface $request
    ) {
        $this->get('/info', []);

        $requestFactory->createRequest(
            'GET',
            '/info',
            [],
            ''
        )->shouldHaveBeenCalled();

        $httpClient->sendRequest($request)->shouldHaveBeenCalled();
    }

    function it_can_make_http_post_request(
        HttpClient $httpClient,
        RequestFactory $requestFactory,
        RequestInterface $request
    ) {
        $this->post('create', []);

        $requestFactory->createRequest(
            'POST',
            'create',
            [],
            ''
        )->shouldHaveBeenCalled();

        $httpClient->sendRequest($request)->shouldHaveBeenCalled();
    }
}
