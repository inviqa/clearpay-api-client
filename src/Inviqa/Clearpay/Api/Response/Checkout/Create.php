<?php

namespace Inviqa\Clearpay\Api\Response\Checkout;

use Inviqa\Clearpay\DateTime;
use Inviqa\Clearpay\Http\Response;

class Create
{
    /**
     * @var string
     */
    private $token;
    /**
     * @var \DateTimeInterface|null
     */
    private $expires;
    /**
     * @var string
     */
    private $redirectCheckoutUrl;

    /**
     * Create constructor.
     *
     * @param string                  $token
     * @param \DateTimeInterface|null $expires
     * @param string                  $redirectCheckoutUrl
     */
    private function __construct(
        string $token,
        $expires,
        string $redirectCheckoutUrl
    ) {
        $this->token = $token;
        $this->expires = $expires;
        $this->redirectCheckoutUrl = $redirectCheckoutUrl;
    }

    public static function fromHttpResponse(Response $response): self
    {
        $state = $response->asDecodedJson(true);

        return new self(
            $state['token'],
            DateTime::fromTimeString($state['expires'])->asDateTime(),
            $state['redirectCheckoutUrl']
        );
    }

    public function token(): string
    {
        return $this->token;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function expires()
    {
        return $this->expires;
    }

    public function redirectCheckoutUrl(): string
    {
        return $this->redirectCheckoutUrl;
    }
}
