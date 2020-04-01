<?php

namespace Inviqa\Clearpay\Http;

use Inviqa\Clearpay\Exception\BadRequestHttpException;
use Inviqa\Clearpay\Exception\ClientErrorHttpException;
use Inviqa\Clearpay\Exception\HttpException;
use Inviqa\Clearpay\Exception\MethodNotAllowedHttpException;
use Inviqa\Clearpay\Exception\NotAcceptableHttpException;
use Inviqa\Clearpay\Exception\NotFoundHttpException;
use Inviqa\Clearpay\Exception\PreconditionFailedHttpException;
use Inviqa\Clearpay\Exception\ServerErrorHttpException;
use Inviqa\Clearpay\Exception\UnauthorizedHttpException;
use Inviqa\Clearpay\Exception\UnsupportedMediaTypeHttpException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ExceptionDelegator
{
    public function transformResponseToException(
        RequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        if ($response->getStatusCode() >= 300 && $response->getStatusCode() < 400) {
            throw HttpException::fromHttpConversation($request, $response);
        }

        if ($response->getStatusCode() === 400) {
            throw BadRequestHttpException::fromHttpConversation($request, $response);
        }

        if ($response->getStatusCode() === 401) {
            throw UnauthorizedHttpException::fromHttpConversation($request, $response);
        }

        if ($response->getStatusCode() === 404) {
            throw NotFoundHttpException::fromHttpConversation($request, $response);
        }

        if ($response->getStatusCode() === 405) {
            throw MethodNotAllowedHttpException::fromHttpConversation($request, $response);
        }

        if ($response->getStatusCode() === 406) {
            throw NotAcceptableHttpException::fromHttpConversation($request, $response);
        }

        if ($response->getStatusCode() === 412) {
            throw PreconditionFailedHttpException::fromHttpConversation($request, $response);
        }

        if ($response->getStatusCode() === 415) {
            throw UnsupportedMediaTypeHttpException::fromHttpConversation($request, $response);
        }

        if ($response->getStatusCode() >= 400 && $response->getStatusCode() < 500) {
            throw ClientErrorHttpException::fromHttpConversation($request, $response);
        }

        if ($response->getStatusCode() >= 500 && $response->getStatusCode() < 600) {
            throw ServerErrorHttpException::fromHttpConversation($request, $response);
        }

        return $response;
    }
}
