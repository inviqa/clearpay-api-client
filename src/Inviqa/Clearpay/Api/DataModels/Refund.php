<?php

namespace Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\DateTime;

class Refund
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var \DateTimeInterface
     */
    private $refundedAt;
    /**
     * @var string
     */
    private $merchantReference;
    /**
     * @var Money
     */
    private $amount;

    private function __construct(
        string $id,
        \DateTimeInterface $refundedAt,
        string $merchantReference,
        Money $amount
    ) {
        $this->id = $id;
        $this->refundedAt = $refundedAt;
        $this->merchantReference = $merchantReference;
        $this->amount = $amount;
    }

    public static function fromState(array $state): self
    {
        return new self(
            $state['id'],
            DateTime::fromISO8601String($state['refundedAt'])->asDateTime(),
            $state['merchantReference'],
            Money::fromState($state['amount'])
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function refundedAt(): \DateTimeInterface
    {
        return $this->refundedAt;
    }

    public function merchantReference(): string
    {
        return $this->merchantReference;
    }

    public function amount(): Money
    {
        return $this->amount;
    }
}
