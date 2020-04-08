<?php

require_once __DIR__ . '/../examples/_bootstrap.php';

$app = new \Inviqa\Clearpay\Application(config());

$domain = sprintf(
    "%s://%s/",
    'https',
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
        'redirectConfirmUrl' => $domain . 'order-confirm.php',
        'redirectCancelUrl'  => $domain . 'order-cancel.php',
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
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://portal.sandbox.clearpay.co.uk/afterpay.js"></script>
</head>
<body>
<div class="container mx-auto mt-20">
    <div class="md:flex md:items-center mb-6">
        <button
            id="clearpay-button"
            class="shadow bg-purple-500 text-white font-bold py-2 px-4 rounded"
            type="submit">
            Pay with Clearpay
        </button>
    </div>
    <div class="md:flex md:items-center mb-6">
        <a id="authorize-button"
           class="shadow bg-purple-500 text-white font-bold py-2 px-4 rounded"
           style="visibility: hidden;"
           href="">
            Authorize
        </a>
    </div>

    <hr>
    Auth Params:
    <pre>
    <?php print_r($params); ?>
    </pre>
    <div id="clearpay-success"></div>
</div>
<script type="text/javascript">
    document.getElementById("clearpay-button").addEventListener("click", function() {
        AfterPay.initialize({countryCode: "GB"});
        AfterPay.open();
        // If you don't already have a checkout token at this point, you can
        // AJAX to your backend to retrieve one here. The spinning animation
        // will continue until `AfterPay.transfer` is called.
        AfterPay.onComplete = function(event) {
            console.log(event.data);

            if (event.data.status == "SUCCESS") {
                // The consumer confirmed the payment schedule.
                // The token is now ready to be captured from your server backend.
                alert('payment okay');
                var token = event.data.orderToken,
                    href = "3-auth-response.php?merchantRef=<?php echo $params['merchantReference']; ?>&token=" + token;

                document.getElementById("clearpay-success").textContent = "Token: " + token;
                document.getElementById("authorize-button").style.visibility = 'visible';
                document.getElementById("authorize-button").setAttribute('href', href);
            } else {
                // The consumer cancelled the payment or closed the popup window.
                alert('payment failed');
            }
        }
        AfterPay.transfer({token: "<?php echo $token; ?>"});
    });
</script>
</body>
</html>
