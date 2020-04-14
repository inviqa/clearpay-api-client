<?php

require_once __DIR__ . '/../vendor/autoload.php';

function config()
{
    return new class implements \Inviqa\Clearpay\Config {

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
            return sprintf(
                'inviqa-clearpay-api-client (%s) examples',
                'PHP/' . PHP_VERSION
            );
        }
    };
}
