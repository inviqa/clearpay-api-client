<?php

namespace Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\DateTime;

class ShippingCourier
{
    /**
     * @var \DateTimeInterface|null
     */
    private $shippedAt;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $tracking;
    /**
     * @var string
     */
    private $priority;

    /**
     * ShippingCourier constructor.
     *
     * @param mixed  $shippedAt
     * @param string $name
     * @param string $tracking
     * @param string $priority
     */
    private function __construct(
        $shippedAt,
        string $name,
        string $tracking,
        string $priority
    ) {
        $this->shippedAt = $shippedAt;
        $this->name = $name;
        $this->tracking = $tracking;
        $this->priority = $priority;
    }

    public static function fromState(array $state): self
    {
        return new self(
            DateTime::fromTimeString($state['shippedAt'])->asDateTime(),
            $state['name'] ?? '',
            $state['tracking'] ?? '',
            $state['priority'] ?? ''
        );
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function shippedAt()
    {
        return $this->shippedAt;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function tracking(): string
    {
        return $this->tracking;
    }

    public function priority(): string
    {
        return $this->priority;
    }
}
