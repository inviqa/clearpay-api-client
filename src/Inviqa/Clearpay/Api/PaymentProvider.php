<?php

namespace Inviqa\Clearpay\Api;

use Inviqa\Clearpay\Api\Response\Payment\Payment;
use Inviqa\Clearpay\Api\Response\Payment\Refund;
use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\Http\HeadersTrait;
use Inviqa\Clearpay\Http\Response;
use Inviqa\Clearpay\JsonHandler;
use Psr\Http\Message\ResponseInterface;

class PaymentProvider
{
    /**
     * @var Adapter
     */
    private $adapter;

    use HeadersTrait;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function auth(
        string $token,
        string $requestId = null,
        string $merchantReference = null
    ): Payment {
        $response = $this->adapter->post(
            'payments/auth',
            $this->defaultPostHeaders(),
            JsonHandler::encode([
                'requestId'         => $requestId,
                'token'             => $token,
                'merchantReference' => $merchantReference
            ])
        );

        return $this->paymentResponse($response);
    }

    public function capture(
        string $orderId,
        string $captureAmount,
        string $captureCurrency,
        string $requestId = null,
        string $merchantReference = null,
        string $paymentEventMerchantReference = null
    ): Payment {
        $result = $this->adapter->post(
            sprintf("payments/%s/capture", $orderId),
            $this->defaultPostHeaders(),
            JsonHandler::encode([
                'requestId'                     => $requestId,
                'amount'                        => [
                    'amount'   => $captureAmount,
                    'currency' => $captureCurrency
                ],
                'merchantReference'             => $merchantReference,
                'paymentEventMerchantReference' => $paymentEventMerchantReference
            ])
        );

        return $this->paymentResponse($result);
    }

    public function void(string $orderId): Payment
    {
        $result = $this->adapter->post(
            sprintf('payments/%s/void', $orderId),
            $this->defaultPostHeaders(),
            null
        );

        return $this->paymentResponse($result);
    }

    public function refund(
        string $orderId,
        string $refundAmount,
        string $refundCurrency,
        string $requestId = null,
        string $merchantReference = null,
        string $refundMerchantReference = null
    ): Refund {
        $response = $this->adapter->post(
            sprintf('payments/%s/refund', $orderId),
            $this->defaultPostHeaders(),
            JsonHandler::encode([
                'requestId'               => $requestId,
                'amount'                  => [
                    'amount'   => $refundAmount,
                    'currency' => $refundCurrency
                ],
                'merchantReference'       => $merchantReference,
                'refundMerchantReference' => $refundMerchantReference
            ])
        );

        return Refund::fromHttpResponse(
            Response::fromHttpResponse($response)
        );
    }

    private function paymentResponse(ResponseInterface $result): Payment
    {
        return Payment::fromHttpResponse(
            Response::fromHttpResponse($result)
        );
    }
}
