<?php

namespace Inviqa\Clearpay\Api\Response;

use Inviqa\Clearpay\Http\Response;

class ConfigurationResponse
{
    /**
     * @var string
     */
    private $minimumAmount;
    /**
     * @var string
     */
    private $minimumCurrency;
    /**
     * @var string
     */
    private $maximumAmount;
    /**
     * @var string
     */
    private $maximumCurrency;

    /**
     * @var array
     */
    private $state = [];

    private function __construct(
        string $minimumAmount,
        string $minimumCurrency,
        string $maximumAmount,
        string $maximumCurrency
    ) {
        $this->minimumAmount = $minimumAmount;
        $this->minimumCurrency = $minimumCurrency;
        $this->maximumAmount = $maximumAmount;
        $this->maximumCurrency = $maximumCurrency;
    }

    public static function fromHttpResponse(Response $response): self
    {
        $state = $response->asDecodedJson(true);

        $configuration = new self(
            $state['minimumAmount']['amount'] ?? '0.00',
            $state['minimumAmount']['currency'] ?? '',
            $state['maximumAmount']['amount'],
            $state['maximumAmount']['currency']
        );

        $configuration->state = $state;

        return $configuration;
    }

    public function getCurrencyCode(): string
    {
        return $this->maximumCurrency;
    }

    public function getMinimumAmount(): string
    {
        return $this->minimumAmount;
    }

    public function getMaximumAmount(): string
    {
        return $this->maximumAmount;
    }

    public function toArray(): array
    {
        return $this->state;
    }
}
