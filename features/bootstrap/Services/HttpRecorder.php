<?php

namespace Services;

use VCR\VCR;
use VCR\Request;

class HttpRecorder
{
    /**
     * @var string
     */
    private $cassettePath;

    public function __construct(string $cassettePath)
    {
        $this->cassettePath = $cassettePath;
    }

    public static function fromShelf($path)
    {
        return new self($path);
    }

    public function powerOn(): void
    {
        VCR::configure()
            ->setCassettePath($this->cassettePath)
            ->addRequestMatcher(
                'header_matcher',
                function (Request $first, Request $second) {
                    $firstHeaders = $first->getHeaders();
                    $secondHeaders = $second->getHeaders();

                    foreach (['Authorization', 'User-Agent'] as $header) {
                        unset($firstHeaders[$header], $secondHeaders[$header]);
                    }
                    unset($header);

                    return $firstHeaders == $secondHeaders;
                }
            )
            ->enableRequestMatchers(['method', 'url', 'query_string', 'host', 'body', 'post_fields', 'header_matcher']);

        VCR::turnOn();
    }

    public function insertCassette(string $cassette)
    {
        VCR::insertCassette($cassette);
    }

    public function eject(): void
    {
        VCR::eject();
    }

    public function powerOff(): void
    {
        VCR::turnOff();
    }
}
