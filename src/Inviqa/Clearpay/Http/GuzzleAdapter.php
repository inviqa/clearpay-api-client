<?php

namespace Inviqa\Clearpay\Http;

use GuzzleHttp\Client as GuzzleHttp;

class GuzzleAdapter implements Adapter
{
    /**
     * @var GuzzleHttp
     */
    private $guzzleHttp;

    public function __construct(GuzzleHttp $guzzleHttp)
    {
        $this->guzzleHttp = $guzzleHttp;
    }

    /**
     * @inheritDoc
     */
    public function get(string $uri, $options = [])
    {
        return $this->guzzleHttp->get($uri, $options);
    }

    /**
     * @inheritDoc
     */
    public function post(string $uri, $options = [])
    {
        return $this->guzzleHttp->post($uri, $options);
    }
}
