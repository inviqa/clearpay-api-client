<?php

namespace Inviqa\Clearpay\Api\Response\Payment;

use Inviqa\Clearpay\Api\DataModels\Money;
use Inviqa\Clearpay\Http\Response;
use Inviqa\Clearpay\Api\DataModels\Refund as RefundDataModel;

class Refund
{
    /**
     * @var RefundDataModel
     */
    private $refundDataModel;

    private function __construct(RefundDataModel $refundDataModel)
    {
        $this->refundDataModel = $refundDataModel;
    }

    public static function fromHttpResponse(Response $response): self
    {
        return new self(
            RefundDataModel::fromState(
                $response->asDecodedJson(true)
            )
        );
    }

    public function refundId(): string
    {
        return $this->refundDataModel->id();
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function refundedAt()
    {
        return $this->refundDataModel->refundedAt();
    }

    public function merchantReference(): string
    {
        return $this->refundDataModel->merchantReference();
    }

    public function amount(): Money
    {
        return $this->refundDataModel->amount();
    }
}
