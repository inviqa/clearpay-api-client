<?php

require_once __DIR__ . '/_bootstrap.php';

$app = new \Inviqa\Clearpay\Application(config());

$token = $argv[1] ?? false || die('Token must be present' . PHP_EOL);
$requestId = $argv[2] ?? null;
$merchantRef = $argv[3] ?? null;

try {
    $result = $app->paymentAuth(
        $token,
        $requestId,
        $merchantRef
    );
    unset($token, $requestId, $merchantRef);
    echo "Payment Id: " . $result->id() . PHP_EOL;
    echo "Payment Satus: " . $result->status() . PHP_EOL;
    echo "Payment State: " . $result->paymentState() . PHP_EOL;
}
catch (Exception $e) {
    echo "Message: " . $e->getMessage() . PHP_EOL;
    echo "Code: " . $e->getCode() . PHP_EOL;
}
