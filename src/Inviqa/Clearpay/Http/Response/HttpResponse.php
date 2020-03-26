<?php

namespace Inviqa\Clearpay\Http\Response;

class HttpResponse
{
    /**
     * @var string
     */
    private $content;

    private function __construct()
    {
    }

    public static function fromContent(string $content): HttpResponse
    {
        $instance = new self;
        $instance->content = $content;

        return $instance;
    }

    public static function fromError(string $error): HttpResponse
    {
        $instance = new self;
        $instance->content = $error;

        return $instance;
    }

    public function content(): string
    {
        return $this->content;
    }
}
