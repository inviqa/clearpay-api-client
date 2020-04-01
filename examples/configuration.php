<?php

require_once __DIR__ . '/_bootstrap.php';

$app = new \Inviqa\Clearpay\Application(config());

try {
    var_dump($app->getConfiguration());
}
catch (Exception $e) {
    echo "Code: " . $e->getCode() . PHP_EOL;
    echo "Message: " . $e->getMessage() . PHP_EOL;
}
