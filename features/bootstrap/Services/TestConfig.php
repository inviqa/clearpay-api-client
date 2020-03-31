<?php

namespace Services;

use Inviqa\Clearpay\Config;

class TestConfig implements Config
{
    /**
     * @var HttpRecorder
     */
    private $httpRecorder;

    public function __construct($cassettePath)
    {
        $this->httpRecorder = HttpRecorder::fromShelf($cassettePath);
        $this->httpRecorder->powerOn();
    }

    public function uri(): string
    {
        return "https://api.eu-sandbox.afterpay.com/v2/";
    }

    public function username(): string
    {
        return '400123968';
    }

    public function password(): string
    {
        return 'b8218f6fe7e42d5653d78cd607ea0638a6379113d3492c9700ab877a9d2c1347464de0094301bfb6a69b27590d7e57800ab6494ac87a60299542844e0f42fa8f';
    }

    public function httpRecorder(): HttpRecorder
    {
        return $this->httpRecorder;
    }
}
