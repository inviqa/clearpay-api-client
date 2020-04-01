<?php

namespace Services;

use Inviqa\Clearpay\Config;

class HttpMockConfig extends TestConfig implements Config
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

    public function httpRecorder(): HttpRecorder
    {
        return $this->httpRecorder;
    }
}
