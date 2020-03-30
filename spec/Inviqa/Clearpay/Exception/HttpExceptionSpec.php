<?php

namespace spec\Inviqa\Clearpay\Exception;

use Inviqa\Clearpay\Exception\HttpException;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class HttpExceptionSpec extends ObjectBehavior
{
    function let(
        RequestInterface $request,
        ResponseInterface $response,
        StreamInterface $stream,
        \Exception $e
    ) {
        $stream->getContents()->willReturn('');
        $stream->rewind()->willReturn($stream);

        $response->getBody()->willReturn($stream);
        $response->getStatusCode()->willReturn(403);
        $response->getReasonPhrase()->willReturn('Forbidden');

        $this->beConstructedFromHttpConversation($request, $response, $e);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HttpException::class);
        $this->shouldHaveType(\RuntimeException::class);
    }

    function it_has_http_request(RequestInterface $request)
    {
        $this->httpRequest()->shouldBe($request);
    }

    function it_has_http_response(ResponseInterface $response)
    {
        $this->httpResponse()->shouldBe($response);
    }

    function it_has_default_message()
    {
        $this->getMessage()->shouldStartWith('Forbidden see');
    }

    function it_can_decode_json_response_body_for_message(
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $json = <<<JSON
{
  "errorCode" : "invalid_json",
  "errorId" : "3a96d8eab0d7ed1e",
  "message" : "The request contains improperly formatted JSON",
  "httpStatusCode" : 400
}
JSON;

        $stream->getContents()->willReturn($json);
        $response->getStatusCode()->willReturn(400);
        $response->getReasonPhrase()->willReturn('Bad Request');

        $this->getMessage()->shouldStartWith('The request contains improperly formatted JSON');
    }
}
