<?php

namespace Inviqa\Clearpay\Api\DataModels;

class Money
{
    /**
     * @var string
     */
    private $amount;
    /**
     * @var string
     */
    private $currency;

    private function __construct(string $amount, string $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public static function fromState(array $state = []): self
    {
        return new self(
            $state['amount'] ?? '',
            $state['currency'] ?? ''
        );
    }

    public function amount(): string
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }
}
