<?php

namespace Inviqa\Clearpay\Api\DataModels;

class Discount
{
    /**
     * @var string
     */
    private $displayName;
    /**
     * @var Money
     */
    private $amount;

    private function __construct(
        string $displayName,
        Money $amount
    ) {
        $this->displayName = $displayName;
        $this->amount = $amount;
    }

    public static function fromState(array $state): self
    {
        return new self(
            $state['displayName'],
            Money::fromState($state['amount'])
        );
    }

    public function displayName(): string
    {
        return $this->displayName;
    }

    public function amount(): Money
    {
        return $this->amount;
    }
}
