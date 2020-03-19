<?php

namespace Inviqa\Clearpay\Http;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Inviqa\Clearpay\Http\Response\HttpResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Client implements Adapter
{
    /**
     * @var HttpClient
     */
    private $httpClient;
    /**
     * @var RequestFactory
     */
    private $requestFactory;
    /**
     * @var ExceptionDelegator
     */
    private $exceptionDelegator;

    public function __construct(
        HttpClient $httpClient,
        RequestFactory $requestFactory
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->exceptionDelegator = new ExceptionDelegator;
    }

    /**
     * @inheritDoc
     */
    public function get(string $uri, $options = [])
    {
        try {
            $response = $this->httpClient->sendRequest(
                $this->requestFactory->createRequest(
                    'GET',
                    $uri,
                    [],
                    ''
                )
            );
        } catch (\Exception $e) {
            return HttpResponse::fromError($e->getMessage());
        }

        return HttpResponse::fromContent($response->getBody()->getContents());
    }

    /**
     * @inheritDoc
     */
    public function post($uri, array $headers = [], $body = null)
    {
        return $this->handleRequest('POST', $uri, $headers, $body);
    }

    /**
     * @param string                               $method
     * @param string|UriInterface                  $uri
     * @param array                                $headers
     * @param resource|string|StreamInterface|null $body
     *
     * @return ResponseInterface
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    private function handleRequest(
        string $method,
        $uri,
        array $headers,
        $body
    ): ResponseInterface {
        $request = $this->requestFactory->createRequest(
            $method,
            $uri,
            $headers,
            $body
        );

        $response = $this->httpClient->sendRequest($request);
        $response = $this->delegateExceptions($request, $response);

        return $response;
    }

    private function delegateExceptions(
        RequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        return $this->exceptionDelegator->transformResponseToException(
            $request,
            $response
        );
    }
}
