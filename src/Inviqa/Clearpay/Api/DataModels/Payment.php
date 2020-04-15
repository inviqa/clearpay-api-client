<?php

namespace Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Collection;
use Inviqa\Clearpay\DateTime;

class Payment
{
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_DECLINED = 'DECLINED';

    const PAYMENT_STATE_AUTH_APPROVED = 'AUTH_APPROVED';
    const PAYMENT_STATE_AUTH_DECLINED = 'AUTH_DECLINED';
    const PAYMENT_STATE_PARTIALLY_CAPTURED = 'PARTIALLY_CAPTURED';
    const PAYMENT_STATE_CAPTURED = 'CAPTURED';
    const PAYMENT_STATE_CAPTURE_DECLINED = 'CAPTURE_DECLINED';
    const PAYMENT_STATE_VOIDED = 'VOIDED';

    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $token;
    /**
     * @var string
     */
    private $status;
    /**
     * @var string
     */
    private $paymentState;
    /**
     * @var string
     */
    private $merchantReference;
    /**
     * @var \DateTimeInterface|null
     */
    private $createdAt;
    /**
     * @var Money
     */
    private $originalAmount;
    /**
     * @var Money
     */
    private $openToCaptureAmount;
    /**
     * @var OrderDetails
     */
    private $orderDetails;
    /**
     * @var Collection
     */
    private $refunds;
    /**
     * @var Collection
     */
    private $events;

    use CommonTrait;

    /**
     * Payment constructor.
     *
     * @param string                  $id
     * @param string                  $token
     * @param string                  $status
     * @param string                  $paymentState
     * @param string                  $merchantReference
     * @param \DateTimeInterface|null $createdAt
     * @param Money                   $originalAmount
     * @param Money                   $openToCaptureAmount
     * @param OrderDetails            $orderDetails
     * @param Collection              $refunds
     * @param Collection              $events
     */
    private function __construct(
        string $id,
        string $token,
        string $status,
        string $paymentState,
        string $merchantReference,
        $createdAt,
        Money $originalAmount,
        Money $openToCaptureAmount,
        OrderDetails $orderDetails,
        Collection $refunds,
        Collection $events
    ) {
        $this->id = $id;
        $this->token = $token;
        $this->status = $status;
        $this->paymentState = $paymentState;
        $this->merchantReference = $merchantReference;
        $this->createdAt = $createdAt;
        $this->originalAmount = $originalAmount;
        $this->openToCaptureAmount = $openToCaptureAmount;
        $this->orderDetails = $orderDetails;
        $this->refunds = $refunds;
        $this->events = $events;
    }

    public static function fromState(array $state): self
    {
        $refunds = self::map($state['refunds'], function (array $refund) {
            return Refund::fromState($refund);
        });

        $events = self::map($state['events'], function (array $event) {
            return PaymentEvent::fromState($event);
        });

        return new self(
            $state['id'],
            $state['token'],
            $state['status'],
            $state['paymentState'],
            $state['merchantReference'],
            DateTime::fromTimeString($state['created'])->asDateTime(),
            Money::fromState($state['originalAmount']),
            Money::fromState($state['openToCaptureAmount']),
            OrderDetails::fromState($state['orderDetails']),
            $refunds,
            $events
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function token(): string
    {
        return $this->token;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function paymentState(): string
    {
        return $this->paymentState;
    }

    public function merchantReference(): string
    {
        return $this->merchantReference;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function createdAt()
    {
        return $this->createdAt;
    }

    public function originalAmount(): Money
    {
        return $this->originalAmount;
    }

    public function openToCaptureAmount(): Money
    {
        return $this->openToCaptureAmount;
    }

    public function orderDetails(): OrderDetails
    {
        return $this->orderDetails;
    }

    public function refunds(): Collection
    {
        return $this->refunds;
    }

    public function events(): Collection
    {
        return $this->events;
    }
}
