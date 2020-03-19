<?php

require_once __DIR__ . '/_bootstrap.php';

$app = new \Inviqa\Clearpay\Application(config());

$params = [
    'amount'   => [
        'amount'   => '30.00',
        'currency' => 'GBP'
    ],
    'consumer' => [
        'phoneNumber' => '0123456789',
        'givenNames'  => 'Testy',
        'surname'     => 'testerson',
        'email'       => 'name@example.com'
    ],
    'merchant' => [
        'redirectConfirmUrl' => 'https://example.com/checkout/confirm',
        'redirectCancelUrl'  => 'https://example.com/checkout/cancel',
    ]
];

try {
    $result = $app->createCheckout($params);

    echo "Token: " . $result->token() . PHP_EOL;
    echo "Expires: " . $result->expires()->format('Y-m-d H:i:s') . PHP_EOL;
    echo "Redirect URL: "  . $result->redirectCheckoutUrl() .  PHP_EOL;
}
catch (Exception $e) {
    echo "Code: " . $e->getCode() . PHP_EOL;
    echo "Message: " . $e->getMessage() . PHP_EOL;
}
