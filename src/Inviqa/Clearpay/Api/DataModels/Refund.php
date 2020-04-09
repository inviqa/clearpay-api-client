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
     * @var \DateTimeInterface|null
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

    /**
     * Refund constructor.
     *
     * @param string                  $id
     * @param \DateTimeInterface|null $refundedAt
     * @param string                  $merchantReference
     * @param Money                   $amount
     */
    private function __construct(
        string $id,
        $refundedAt,
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
            DateTime::fromTimeString($state['refundedAt'])->asDateTime(),
            $state['merchantReference'] ?? '',
            Money::fromState($state['amount'])
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function refundedAt()
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
