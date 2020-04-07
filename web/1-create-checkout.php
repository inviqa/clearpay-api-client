<?php

require_once __DIR__ . '/../examples/_bootstrap.php';

$app = new \Inviqa\Clearpay\Application(config());

$domain = sprintf(
    "%s://%s/",
    'http',
    $_SERVER['HTTP_HOST']
);

$defaults = [
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
        'redirectConfirmUrl' => $domain . 'confirm.php',
        'redirectCancelUrl'  => $domain . 'cancel.php',
    ]
];
unset($domain);

$params = array_merge($defaults, $_POST);

try {
    $token = $app->createCheckout($params)->token();
} catch (Exception $e) {
    die($e->getMessage());
}
?>
<html>
<head>
    <script type="text/javascript" src="https://portal.sandbox.clearpay.co.uk/afterpay.js"></script>
</head>
<body>
<button id="clearpay-button">
    Clearpay it!
</button>
<pre>
    <?php print_r($params); ?>
</pre>
<script type="text/javascript">
    document.getElementById("clearpay-button").addEventListener("click", function() {
        AfterPay.initialize({countryCode: "GB"});
        AfterPay.open();
        // If you don't already have a checkout token at this point, you can
        // AJAX to your backend to retrieve one here. The spinning animation
        // will continue until `AfterPay.transfer` is called.
        AfterPay.onComplete = function(event) {
            if (event.data.status == "SUCCESS") {
                // The consumer confirmed the payment schedule.
                // The token is now ready to be captured from your server backend.
            } else {
                // The consumer cancelled the payment or closed the popup window.
            }
        }
        AfterPay.transfer({token: "<?php echo $token; ?>"});
    });
</script>
</body>
</html>
