<?php

namespace Inviqa\Clearpay\Api;

use Inviqa\Clearpay\Api\Response\Checkout\Create;
use Inviqa\Clearpay\Http\Adapter;

class CheckoutProvider
{
    /**
     * @var Adapter
     */
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function createCheckout(array $params = []): Create
    {
        $response = $this->adapter->post(
            'checkouts',
            [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ],
            json_encode($params)
        );

        return Create::fromHttpResponse($response);
    }
}
