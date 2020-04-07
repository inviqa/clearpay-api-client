<?php

namespace Inviqa\Clearpay\Http;

use Inviqa\Clearpay\Exception\JsonException;
use Inviqa\Clearpay\JsonHandler;
use Psr\Http\Message\ResponseInterface;

class Response
{
    /**
     * @var ResponseInterface
     */
    private $response;

    private function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public static function fromHttpResponse(ResponseInterface $response): self
    {
        return new self($response);
    }

    /**
     * @param bool $assoc
     *
     * @return mixed
     * @throws JsonException
     */
    public function asDecodedJson($assoc = false)
    {
        return JsonHandler::decode(
            $this->response->getBody()->getContents(),
            $assoc
        );
    }
}
