<?php

namespace Inviqa\Clearpay\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

interface Adapter
{
    /**
     * @param string|UriInterface $uri
     * @param array               $headers
     *
     * @return ResponseInterface
     */
    public function get($uri, $headers = []);

    /**
     * @param string|UriInterface                  $uri
     * @param array                                $headers
     * @param resource|string|StreamInterface|null $body
     *
     * @return ResponseInterface
     */
    public function post($uri, array $headers = [], $body = null);
}
