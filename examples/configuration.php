<?php

require_once __DIR__ . '/_bootstrap.php';

$app = new \Inviqa\Clearpay\Application(config());

try {
    $result = $app->getConfiguration();

    echo "Minimum Amount: " . $result->getMinimumAmount() . PHP_EOL;
    echo "Maximum Amount: " . $result->getMaximumAmount() . PHP_EOL;
    echo "Currency:       " . $result->getCurrencyCode() . PHP_EOL;
}
catch (Exception $e) {
    echo "Code: " . $e->getCode() . PHP_EOL;
    echo "Message: " . $e->getMessage() . PHP_EOL;
}
