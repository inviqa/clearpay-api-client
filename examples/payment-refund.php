<?php

require_once __DIR__ . '/_bootstrap.php';

$app = new \Inviqa\Clearpay\Application(config());

$orderId = $argv[1] ?? false || die('Order Id must be present' . PHP_EOL);
$amount = $argv[2] ?? false || die('Amount must be present' . PHP_EOL);
$currency = $argv[3] ?? false || die('Currency must be present' . PHP_EOL);

try {
    $result = $app->paymentRefund(
        $orderId,
        $amount,
        $currency
    );
    unset($orderId, $amount, $currency);

    echo "Refund Id: " . $result->refundId() . PHP_EOL;
    echo "Amount: " . $result->amount()->amount() . PHP_EOL;
    echo "Currency: " . $result->amount()->currency() . PHP_EOL;
}
catch (Exception $e) {
    echo "Message: " . $e->getMessage() . PHP_EOL;
    echo "Code: " . $e->getCode() . PHP_EOL;
}
