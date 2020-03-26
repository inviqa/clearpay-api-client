<?php

namespace Inviqa\Clearpay\Services;

class ConfigurationFactory
{
    public static function successfulConfigurationResponse(): string
    {
        return '{
            "minimumAmount" : {
            "amount" : "10.00",
            "currency" : "GBP"
        },
            "maximumAmount" : {
            "amount" : "1000.00",
            "currency" : "GBP"
        }
       }';
    }
}
