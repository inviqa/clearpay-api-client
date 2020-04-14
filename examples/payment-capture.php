<?php

require_once __DIR__ . '/_bootstrap.php';

$app = new \Inviqa\Clearpay\Application(config());

$orderId = $argv[1] ?? false || die('Order Id must be present' . PHP_EOL);
$amount = $argv[2] ?? false || die('Amount must be present' . PHP_EOL);
$currency = $argv[3] ?? false || die('Currency must be present' . PHP_EOL);

try {
    $result = $app->paymentCapture(
        $orderId,
        $amount,
        $currency
    );
    unset($orderId, $amount, $currency);

    echo "Payment Status: " . $result->status() . PHP_EOL;
    echo "Payment State: " . $result->paymentState() . PHP_EOL;
}
catch (Exception $e) {
    echo "Message: " . $e->getMessage() . PHP_EOL;
    echo "Code: " . $e->getCode() . PHP_EOL;
}
