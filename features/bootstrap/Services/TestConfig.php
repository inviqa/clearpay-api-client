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

    public function userAgent(): string
    {
        $curl = 'curl-not-available';
        if (extension_loaded('curl') && function_exists('curl_version')) {
            $curl = 'curl/' . curl_version()['version'];
        }

        return sprintf(
            'inviqa-clearpay-api-client (%s; %s) integration-test',
            'PHP/' . PHP_VERSION,
            $curl
        );
    }
}
