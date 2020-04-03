<?php

namespace Inviqa\Clearpay\Api;

use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\JsonHandler;

class PaymentProvider
{
    /**
     * @var Adapter
     */
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function auth(
        string $token,
        string $requestId = null,
        string $merchantReference = null
    ) {
        $params = [
            'requestId'         => $requestId,
            'token'             => $token,
            'merchantReference' => $merchantReference
        ];

         return $this->adapter->post(
            'payments/auth',
            [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ],
            JsonHandler::encode($params)
        );
    }
}