<?php

require_once __DIR__ . '/../examples/_bootstrap.php';

if ($_POST) {
    $token = $_POST['token'] ?? false || die('Token must be present' . PHP_EOL);
    $requestId = $_POST['requestId'] ?? null;
    $merchantRef = $_POST['merchantRef'] ?? null;

    $app = new \Inviqa\Clearpay\Application(config());

    try {
        $result = $app->paymentAuth(
            $token,
            $requestId,
            $merchantRef
        );
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

?>
<html>
<head>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css"
          rel="stylesheet">
</head>
<body>
<body>
<div class="container mx-auto mt-20">
    <?php if($_POST): ?>
    <hr>
    Auth Response:
    <pre>
    <?php print_r($result); ?>
    </pre>
    <?php endif; ?>
    <form action="3-auth-response.php" method="post">
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label
                    class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                    for="token">
                    Token
                </label>
            </div>
            <div class="md:w-2/3">
                <input
                    class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight"
                    value="<?php echo $_GET['token'] ?? ''; ?>" id="token" name="token" type="text">
            </div>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label
                    class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                    for="merchantRef">
                    Merchant Reference
                </label>
            </div>
            <div class="md:w-2/3">
                <input
                    class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight"
                    value="<?php echo $_GET['merchantRef'] ?? ''; ?>" id="merchantRef" name="merchantRef" type="text">
            </div>
        </div>

        <div class="md:flex md:items-center">
            <div class="md:w-1/3"></div>
            <div class="md:w-2/3">
                <button
                    class="shadow bg-purple-500 text-white font-bold py-2 px-4 rounded"
                    type="submit">
                    Authorize
                </button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
