<?php

namespace Inviqa\Clearpay\Api;

use Inviqa\Clearpay\Api\Response\Payment\Auth;
use Inviqa\Clearpay\Api\Response\Payment\Refund;
use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\Http\HeadersTrait;
use Inviqa\Clearpay\Http\Response;
use Inviqa\Clearpay\JsonHandler;

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
    ): Auth {
        $response = $this->adapter->post(
            'payments/auth',
            $this->defaultPostHeaders(),
            JsonHandler::encode([
                'requestId' => $requestId,
                'token' => $token,
                'merchantReference' => $merchantReference
            ])
        );

        return Auth::fromHttpResponse(
            Response::fromHttpResponse($response)
        );
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
}
