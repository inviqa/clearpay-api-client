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
     * @var \DateTimeInterface|null
     */
    private $createdAt;
    /**
     * @var \DateTimeInterface|null
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

    /**
     * PaymentEvent constructor.
     *
     * @param string                  $id
     * @param \DateTimeInterface|null $createdAt
     * @param \DateTimeInterface|null $expiresAt
     * @param string                  $type
     * @param Money                   $amount
     */
    private function __construct(
        string $id,
        $createdAt,
        $expiresAt,
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
            DateTime::fromTimeString($state['created'])->asDateTime(),
            DateTime::fromTimeString($state['expires'] ?? '')->asDateTime(),
            $state['type'],
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
    public function createdAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function expiresAt()
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
