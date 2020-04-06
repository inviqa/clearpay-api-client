<?php

namespace Inviqa\Clearpay\Api;

use Inviqa\Clearpay\Api\Response\Checkout\Create;
use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\Http\HeadersTrait;
use Inviqa\Clearpay\Http\Response;
use Inviqa\Clearpay\JsonHandler;

class CheckoutProvider
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

    public function createCheckout(array $params = []): Create
    {
        $response = $this->adapter->post(
            'checkouts',
            $this->defaultPostHeaders(),
            JsonHandler::encode($params)
        );

        return Create::fromHttpResponse(
            Response::fromHttpResponse($response)
        );
    }
}
