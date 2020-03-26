<?php

namespace Inviqa\Clearpay\Services;

use Inviqa\Clearpay\Http\Adapter;
use Inviqa\Clearpay\Http\Response\HttpResponse;

class FakeClient implements Adapter
{
    /**
     * @inheritDoc
     */
    public function get(string $uri, $options = [])
    {
        return HttpResponse::fromContent(
            ConfigurationFactory::successfulConfigurationResponse()
        );
    }

    /**
     * @inheritDoc
     */
    public function post(string $uri, $options = [])
    {
        // TODO: Implement post() method.
    }
}