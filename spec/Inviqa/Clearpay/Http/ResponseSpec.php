<?php

namespace spec\Inviqa\Clearpay\Http;

use Inviqa\Clearpay\Http\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResponseSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Response::class);
    }

    function it_has_decoded_json_response_body(
        ResponseInterface $response,
        StreamInterface $stream
    )
    {
        $data = ['one', 'two', 'three'];

        $stream->getContents()->willReturn(json_encode($data));
        $response->getBody()->willReturn($stream);

        $this->beConstructedFromHttpResponse($response);

        $this->asDecodedJson(true)->shouldBe($data);
    }
}
