<?php

namespace Services;

use Inviqa\Clearpay\Config;

class TestConfig implements Config
{
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
}
