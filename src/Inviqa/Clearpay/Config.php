<?php

namespace Inviqa\Clearpay;

interface Config
{
    public function isTestMode() : bool;
    public function uri() : string;
    public function username() : string;
    public function password() : string;
}
