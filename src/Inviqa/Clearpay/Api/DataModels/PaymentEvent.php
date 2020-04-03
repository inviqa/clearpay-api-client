<?php

namespace Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\DateTime;

class PaymentEvent
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var \DateTimeInterface
     */
    private $createdAt;
    /**
     * @var \DateTimeInterface
     */
    private $expiresAt;
    /**
     * @var string
     */
    private $type;
    /**
     * @var Money
     */
    private $amount;

    private function __construct(
        string $id,
        \DateTimeInterface $createdAt,
        \DateTimeInterface $expiresAt,
        string $type,
        Money $amount
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->expiresAt = $expiresAt;
        $this->type = $type;
        $this->amount = $amount;
    }

    public static function fromState(array $state): self
    {
        return new self(
            $state['id'],
            DateTime::fromISO8601String($state['created'])->asDateTime(),
            DateTime::fromISO8601String($state['expires'])->asDateTime(),
            $state['type'],
            Money::fromState($state['amount'])
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function createdAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function expiresAt(): \DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function amount(): Money
    {
        return $this->amount;
    }
}
