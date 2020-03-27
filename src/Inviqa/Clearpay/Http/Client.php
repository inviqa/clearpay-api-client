<?php

namespace Inviqa\Clearpay\Http;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Inviqa\Clearpay\Http\Response\HttpResponse;

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

    public function __construct(
        HttpClient $httpClient,
        RequestFactory $requestFactory
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
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
    public function post(string $uri, $options = [])
    {
        $response = $this->httpClient->sendRequest(
            $this->requestFactory->createRequest(
                'POST',
                $uri,
                [],
                ''
            )
        );
    }
}
