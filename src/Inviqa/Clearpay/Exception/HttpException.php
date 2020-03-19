<?php

namespace Inviqa\Clearpay\Exception;

use Inviqa\Clearpay\JsonHandler;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpException extends \RuntimeException
{
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var ResponseInterface
     */
    private $response;

    final private function __construct(
        RequestInterface $request,
        ResponseInterface $response,
        ?\Exception $previous = null
    ) {
        $message = $this->exceptionMessage($response);

        parent::__construct($message, $response->getStatusCode(), $previous);

        $this->request = $request;
        $this->response = $response;
    }

    public static function fromHttpConversation(
        RequestInterface $request,
        ResponseInterface $response,
        ?\Exception $previous = null
    ): self {
        return new static($request, $response, $previous);
    }

    public function httpRequest(): RequestInterface
    {
        return $this->request;
    }

    public function httpResponse(): ResponseInterface
    {
        return $this->response;
    }

    private function exceptionMessage(ResponseInterface $response): string
    {
        $responseBody = $response->getBody();

        $responseBody->rewind();
        $decodedBody = JsonHandler::decode($responseBody->getContents(), true);
        $responseBody->rewind();

        $message = isset($decodedBody['message']) ? $decodedBody['message'] : $response->getReasonPhrase();

        return sprintf(
            "%s %s",
            $message,
            $this->additionalInformation()
        );
    }

    protected function additionalInformation(): string
    {
        return 'see (https://clearpay-online.readme.io/v2/reference#common-errors)';
    }
}
