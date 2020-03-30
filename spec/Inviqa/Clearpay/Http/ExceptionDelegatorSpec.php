<?php

namespace spec\Inviqa\Clearpay\Http;

use Inviqa\Clearpay\Exception\BadRequestHttpException;
use Inviqa\Clearpay\Exception\ClientErrorHttpException;
use Inviqa\Clearpay\Exception\HttpException;
use Inviqa\Clearpay\Exception\MethodNotAllowedHttpException;
use Inviqa\Clearpay\Exception\NotAcceptableHttpException;
use Inviqa\Clearpay\Exception\NotFoundHttpException;
use Inviqa\Clearpay\Exception\ServerErrorHttpException;
use Inviqa\Clearpay\Exception\UnauthorizedHttpException;
use Inviqa\Clearpay\Exception\UnsupportedMediaTypeHttpException;
use Inviqa\Clearpay\Http\ExceptionDelegator;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ExceptionDelegatorSpec extends ObjectBehavior
{
    function let(
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $stream->rewind()->willReturn($stream);
        $stream->getContents()->willReturn(json_encode([]));
        $response->getBody()->willReturn($stream);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ExceptionDelegator::class);
    }

    function it_can_handle_redirect_responses(
        RequestInterface $request,
        ResponseInterface $response
    ) {
        for ($code = 300; $code < 400; $code++) {
            $response->getStatusCode()->willReturn($code);
            $response->getReasonPhrase()->willReturn((string)$code);

            $this->shouldThrow(HttpException::class)
                ->duringTransformResponseToException(
                    $request,
                    $response
                );
        }
    }

    function it_can_handle_client_errors(
        RequestInterface $request,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $contents = <<<STRING
{
  "errorCode" : "invalid_json",
  "errorId" : "3a96d8eab0d7ed1e",
  "message" : "The request contains improperly formatted JSON",
  "httpStatusCode" : 400
}
STRING;

        $stream->getContents()->willReturn($contents);
        $response->getBody()->willReturn($stream);
        $response->getStatusCode()->willReturn(400);
        $response->getReasonPhrase()->willReturn('Bad Request');

        $this->shouldThrow(BadRequestHttpException::class)
            ->duringTransformResponseToException(
                $request,
                $response
            );
    }

    function it_can_handle_unauthorized_requests(
        RequestInterface $request,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $contents = <<<STRING
{
  "errorCode" : "unauthorized",
  "errorId" : "ac73070c7d527913",
  "message" : "Credentials are required to access this resource.",
  "httpStatusCode" : 401
}
STRING;

        $stream->getContents()->willReturn($contents);
        $response->getBody()->willReturn($stream);
        $response->getStatusCode()->willReturn(401);
        $response->getReasonPhrase()->willReturn('Unauthorized');

        $this->shouldThrow(UnauthorizedHttpException::class)
            ->duringTransformResponseToException(
                $request,
                $response
            );
    }

    function it_can_handle_not_found_requests(
        RequestInterface $request,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $contents = <<<STRING
{
  "errorCode" : "not_found",
  "errorId" : "6d3bf2994802ae8a",
  "message" : "Token not found.",
  "httpStatusCode" : 404
}
STRING;

        $stream->getContents()->willReturn($contents);
        $response->getBody()->willReturn($stream);
        $response->getStatusCode()->willReturn(404);
        $response->getReasonPhrase()->willReturn('Not Found');

        $this->shouldThrow(NotFoundHttpException::class)
            ->duringTransformResponseToException(
                $request,
                $response
            );
    }

    function it_can_handle_method_not_allowed_requests(
        RequestInterface $request,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $contents = <<<STRING
{
  "errorCode" : "method_not_allowed",
  "errorId" : "43c8cffda98cbf47",
  "message" : "Method Not Allowed",
  "httpStatusCode" : 405
}
STRING;

        $stream->getContents()->willReturn($contents);
        $response->getBody()->willReturn($stream);
        $response->getStatusCode()->willReturn(405);
        $response->getReasonPhrase()->willReturn('Method Not Allowed');

        $this->shouldThrow(MethodNotAllowedHttpException::class)
            ->duringTransformResponseToException(
                $request,
                $response
            );
    }

    function it_can_handle_not_acceptable_requests(
        RequestInterface $request,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $contents = <<<STRING
{
  "errorCode" : "error",
  "errorId" : "8ff5eb2a9b992591",
  "message" : "Not Acceptable",
  "httpStatusCode" : 406
}
STRING;

        $stream->getContents()->willReturn($contents);
        $response->getBody()->willReturn($stream);
        $response->getStatusCode()->willReturn(406);
        $response->getReasonPhrase()->willReturn('Not Acceptable');

        $this->shouldThrow(NotAcceptableHttpException::class)
            ->duringTransformResponseToException(
                $request,
                $response
            );
    }

    function it_can_handle_unsupported_media_type_requests(
        RequestInterface $request,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $contents = <<<STRING
{
  "errorCode" : "error",
  "errorId" : "b9fe2f40395b435d",
  "message" : "Unsupported Media Type",
  "httpStatusCode" : 415
}"
STRING;

        $stream->getContents()->willReturn($contents);
        $response->getBody()->willReturn($stream);
        $response->getStatusCode()->willReturn(415);
        $response->getReasonPhrase()->willReturn('Unsupported Media Type');

        $this->shouldThrow(UnsupportedMediaTypeHttpException::class)
            ->duringTransformResponseToException(
                $request,
                $response
            );
    }

    function it_can_handle_other_bad_client_requests(
        RequestInterface $request,
        ResponseInterface $response
    ) {
        for ($code = 400; $code < 500; $code++) {

            $response->getStatusCode()->willReturn($code);
            $response->getReasonPhrase()->willReturn((string)$code);

            $this->shouldThrow(ClientErrorHttpException::class)
                ->duringTransformResponseToException(
                    $request,
                    $response
                );
        }
    }

    function it_can_handle_server_error_responses(
        RequestInterface $request,
        ResponseInterface $response
    ) {
        for ($code = 500; $code < 600; $code++) {
            $response->getStatusCode()->willReturn($code);
            $response->getReasonPhrase()->willReturn((string)$code);

            $this->shouldThrow(ServerErrorHttpException::class)
                ->duringTransformResponseToException(
                    $request,
                    $response
                );
        }
    }
}
