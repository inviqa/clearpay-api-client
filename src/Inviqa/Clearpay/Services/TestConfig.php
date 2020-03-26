<?php

namespace Inviqa\Clearpay\Services;

use Inviqa\Clearpay\Config;

class TestConfig implements Config
{
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function uri(): string
    {
        return "https://api.eu-sandbox.afterpay.com/v2/";
    }
}
