<?php

namespace Inviqa\Clearpay;

interface Config
{
    public function uri() : string;
    public function username() : string;
    public function password() : string;
    public function userAgent() : string;
}
