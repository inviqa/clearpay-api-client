<?php

require_once __DIR__ . '/../examples/_bootstrap.php';

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
?>
<html>
<head>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css"
          rel="stylesheet">
</head>
<body>
<body>
<div class="container mx-auto mt-20">
    <form action="1-create-checkout.php" method="post">
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label
                    class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                    for="givenNames">
                    Name
                </label>
            </div>
            <div class="md:w-2/3">
                <input
                    class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight"
                    value="Testy" id="givenNames" name="consumer[givenNames]" type="text">
            </div>
        </div>

        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label
                    class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                    for="surname">
                    Surname
                </label>
            </div>
            <div class="md:w-2/3">
                <input
                    class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight"
                    value="Testerson" id="surname" name="consumer[surname]" type="text">
            </div>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label
                    class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                    for="email">
                    Email
                </label>
            </div>
            <div class="md:w-2/3">
                <input
                    class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight"
                    id="email" name="consumer[email]" type="text">
            </div>
        </div>

        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label
                    class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                    for="phoneNumber">
                    Phone Number
                </label>
            </div>
            <div class="md:w-2/3">
                <input
                    class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight"
                    id="phoneNumber" name="consumer[phoneNumber]" type="text">
            </div>
        </div>

        <div class="md:flex md:items-center">
            <div class="md:w-1/3"></div>
            <div class="md:w-2/3">
                <button
                    class="shadow bg-purple-500 text-white font-bold py-2 px-4 rounded"
                    type="submit">
                    Send
                </button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
