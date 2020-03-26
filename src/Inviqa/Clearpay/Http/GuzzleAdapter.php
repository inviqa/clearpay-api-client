<?php

namespace Inviqa\Clearpay\Http;

use GuzzleHttp\Client as GuzzleHttp;
use Inviqa\Clearpay\Http\Response\HttpResponse;

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
        try {
            $response = $this->guzzleHttp->get($uri, $options);
        } catch (\Exception $e) {
            return HttpResponse::fromError($e->getMessage());
        }

        return HttpResponse::fromContent($response->getBody()->getContents());
    }

    /**
     * @inheritDoc
     */
    public function post(string $uri, $options = [])
    {
        return $this->guzzleHttp->post($uri, $options);
    }
}
