<?php

namespace Inviqa\Clearpay\Api\Response\Checkout;

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

    public static function fromHttpResponse(ResponseInterface $response)
    {
        $data = json_decode($response->getBody()->getContents(), true);

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
     * @return \DateTimeImmutable|false
     */
    private static function toDateTime($time)
    {
        return \DateTimeImmutable::createFromFormat(
            'Y-m-d\TH:i:s.u+',
            $time,
            new \DateTimeZone('UTC')
        );
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
