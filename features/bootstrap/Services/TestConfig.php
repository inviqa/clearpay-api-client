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
        return getenv('CLEARPAY_URI');
    }

    public function username(): string
    {
        return getenv('CLEARPAY_USERNAME');
    }

    public function password(): string
    {
        return getenv('CLEARPAY_PASSWORD');
    }

    public function httpRecorder(): HttpRecorder
    {
        return $this->httpRecorder;
    }
}
