<?php

namespace Inviqa\Clearpay\Api\Response\Payment;

use Inviqa\Clearpay\Api\DataModels\Payment as PaymentDataModel;
use Inviqa\Clearpay\Http\Response;

class Payment
{
    /**
     * @var PaymentDataModel
     */
    private $payment;

    private function __construct(PaymentDataModel $payment)
    {
        $this->payment = $payment;
    }

    public static function fromHttpResponse(Response $response): self
    {
        return new self(
            PaymentDataModel::fromState(
                $response->asDecodedJson(true)
            )
        );
    }

    public function payment(): PaymentDataModel
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
        return $this->payment()->status() === PaymentDataModel::STATUS_APPROVED;
    }

    public function paymentStatusDeclined(): bool
    {
        return $this->payment()->status() === PaymentDataModel::STATUS_DECLINED;
    }

    public function paymentState(): string
    {
        return $this->payment()->paymentState();
    }

    public function paymentStateAuthApproved(): bool
    {
        return $this->paymentState() === PaymentDataModel::PAYMENT_STATE_AUTH_APPROVED;
    }

    public function paymentStateAuthDeclined(): bool
    {
        return $this->paymentState() === PaymentDataModel::PAYMENT_STATE_AUTH_DECLINED;
    }

    public function paymentStatePartiallyCaptured(): bool
    {
        return $this->paymentState() === PaymentDataModel::PAYMENT_STATE_PARTIALLY_CAPTURED;
    }

    public function paymentStateCaptured(): bool
    {
        return $this->paymentState() === PaymentDataModel::PAYMENT_STATE_CAPTURED;
    }

    public function paymentStateCaptureDeclined(): bool
    {
        return $this->paymentState() === PaymentDataModel::PAYMENT_STATE_CAPTURE_DECLINED;
    }

    public function paymentStateVoided(): bool
    {
        return $this->paymentState() === PaymentDataModel::PAYMENT_STATE_VOIDED;
    }
}
