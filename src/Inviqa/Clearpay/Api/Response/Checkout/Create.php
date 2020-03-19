<?php

namespace Inviqa\Clearpay\Api\Response\Checkout;

use Inviqa\Clearpay\DateTime;
use Inviqa\Clearpay\JsonHandler;
use Psr\Http\Message\ResponseInterface;

class Create
{
    /**
     * @var string
     */
    private $token;
    /**
     * @var \DateTimeInterface
     */
    private $expires;
    /**
     * @var string
     */
    private $redirectCheckoutUrl;

    private function __construct(
        string $token,
        \DateTimeInterface $expires,
        string $redirectCheckoutUrl
    ) {
        $this->token = $token;
        $this->expires = $expires;
        $this->redirectCheckoutUrl = $redirectCheckoutUrl;
    }

    public static function fromHttpResponse(ResponseInterface $response): self
    {
        $data = JsonHandler::decode(
            $response->getBody()->getContents(),
            true
        );

        return new self(
            $data['token'],
            self::toDateTime($data['expires']),
            $data['redirectCheckoutUrl']
        );
    }

    /**
     * @see https://bugs.php.net/bug.php?id=51950
     *
     * @param string $time
     *
     * @return \DateTimeInterface
     */
    private static function toDateTime(string $time): \DateTimeInterface
    {
        return DateTime::fromISO8601String($time)->asDateTime();
    }

    public function token(): string
    {
        return $this->token;
    }

    public function expires(): \DateTimeInterface
    {
        return $this->expires;
    }

    public function redirectCheckoutUrl(): string
    {
        return $this->redirectCheckoutUrl;
    }
}
