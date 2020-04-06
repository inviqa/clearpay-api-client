<?php

namespace Inviqa\Clearpay\Api\Response\Payment;

use Inviqa\Clearpay\Api\DataModels\Payment;
use Inviqa\Clearpay\JsonHandler;
use Psr\Http\Message\ResponseInterface;

class Auth
{
    /**
     * @var Payment
     */
    private $payment;

    private function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public static function fromHttpResponse(ResponseInterface $response): self
    {
        $state = JsonHandler::decode($response->getBody()->getContents(), true);

        return new self(
            Payment::fromState($state)
        );
    }

    public function payment(): Payment
    {
        return $this->payment;
    }

    public function id(): string
    {
        return $this->payment()->id();
    }

    public function token(): string
    {
        return $this->payment()->token();
    }

    public function merchantReference(): string
    {
        return $this->payment()->merchantReference();
    }

    public function status(): string
    {
        return $this->payment()->status();
    }

    public function paymentStatusApproved(): bool
    {
        return $this->payment()->status() === Payment::STATUS_APPROVED;
    }

    public function paymentStatusDeclined(): bool
    {
        return $this->payment()->status() === Payment::STATUS_DECLINED;
    }

    public function paymentState(): string
    {
        return $this->payment()->paymentState();
    }

    public function paymentStateAuthApproved(): bool
    {
        return $this->paymentState() === Payment::PAYMENT_STATE_AUTH_APPROVED;
    }

    public function paymentStateAuthDeclined(): bool
    {
        return $this->paymentState() === Payment::PAYMENT_STATE_AUTH_DECLINED;
    }

    public function paymentStatePartiallyCaptured(): bool
    {
        return $this->paymentState() === Payment::PAYMENT_STATE_PARTIALLY_CAPTURED;
    }

    public function paymentStateCaptured(): bool
    {
        return $this->paymentState() === Payment::PAYMENT_STATE_CAPTURED;
    }

    public function paymentStateCaptureDeclined(): bool
    {
        return $this->paymentState() === Payment::PAYMENT_STATE_CAPTURE_DECLINED;
    }

    public function paymentStateVoided(): bool
    {
        return $this->paymentState() === Payment::PAYMENT_STATE_VOIDED;
    }
}
