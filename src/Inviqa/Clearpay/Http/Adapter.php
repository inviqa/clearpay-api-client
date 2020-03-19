<?php

namespace Inviqa\Clearpay\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

interface Adapter
{
    /**
     * @param string $uri
     * @param array  $options
     *
     * @return mixed
     */
    public function get(string $uri, $options = []);

    /**
     * @param string|UriInterface                  $uri
     * @param array                                $headers
     * @param resource|string|StreamInterface|null $body
     *
     * @return ResponseInterface
     */
    public function post($uri, array $headers = [], $body = null);
}
