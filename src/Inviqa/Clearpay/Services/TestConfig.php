<?php

namespace Inviqa\Clearpay\Services;

use Inviqa\Clearpay\Config;

class TestConfig implements Config
{
    public function isTestMode(): bool
    {
        return true;
    }

    public function username(): string
    {
        return "123456";
    }

    public function password(): string
    {
        return "sdfadfgg";
    }

    public function uri(): string
    {
        return "https://api.eu-sandbox.afterpay.com/v2/";
    }
}
