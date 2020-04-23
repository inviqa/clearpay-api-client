<?php

namespace Inviqa\Clearpay;

use Inviqa\Clearpay\Api\Response\Checkout\Create;
use Inviqa\Clearpay\Api\Response\ConfigurationResponse;
use Inviqa\Clearpay\Api\Response\Payment\Payment;
use Inviqa\Clearpay\Api\Response\Payment\Refund;
use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\Http\Factory;

class Application
{
    /**
     * @var Adapter
     */
    private $client;

    /**
     * @var Config
     */
    private $config;

    public function __construct(
        Config $config,
        ?Adapter $client = null
    ) {
        $this->config = $config;
        $this->client = $client ?: Factory::create($config);
    }

    public function getConfiguration(): ConfigurationResponse
    {
        return (new Api\ConfigurationProvider($this->client))->getConfiguration();
    }

    public function createCheckout(array $params = []): Create
    {
        return (new Api\CheckoutProvider($this->client))->createCheckout($params);
    }

    public function paymentAuth(
        string $token,
        string $requestId = null,
        string $merchantReference = null
    ): Payment {
        return (new Api\PaymentProvider($this->client))->auth(
            $token,
            $requestId,
            $merchantReference
        );
    }

    public function paymentCapture(
        string $orderId,
        string $captureAmount,
        string $captureCurrency,
        string $requestId = null,
        string $merchantReference = null,
        string $paymentEventMerchantReference = null
    ): Payment {
        return (new Api\PaymentProvider($this->client))->capture(
            $orderId,
            $captureAmount,
            $captureCurrency,
            $requestId,
            $merchantReference,
            $paymentEventMerchantReference
        );
    }

    public function paymentVoid(string $orderId): Payment
    {
        return (new Api\PaymentProvider($this->client))->void($orderId);
    }

    public function paymentRefund(
        string $orderId,
        string $refundAmount,
        string $refundCurrency,
        string $requestId = null,
        string $merchantReference = null,
        string $refundMerchantReference = null
    ): Refund {
        return (new Api\PaymentProvider($this->client))->refund(
            $orderId,
            $refundAmount,
            $refundCurrency,
            $requestId,
            $merchantReference,
            $refundMerchantReference
        );
    }
}
