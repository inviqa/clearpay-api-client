<?php

require_once __DIR__ . '/_bootstrap.php';

$app = new \Inviqa\Clearpay\Application(config());

$orderId = $argv[1] ?? false || die('Order Id must be present' . PHP_EOL);

try {
    $result = $app->paymentVoid($orderId);
    unset($orderId);

    echo "Order Id: " . $result->id() . PHP_EOL;
    echo "Payment Status: " . $result->status() . PHP_EOL;
    echo "Payment State: " . $result->paymentState() . PHP_EOL;
}
catch (Exception $e) {
    echo "Message: " . $e->getMessage() . PHP_EOL;
    echo "Code: " . $e->getCode() . PHP_EOL;
}
