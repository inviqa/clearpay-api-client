<?php

namespace Contexts\Integration;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Inviqa\Clearpay\Application;
use PHPUnit\Framework\Assert;
use Services\HttpMockConfig;

class CreateCheckoutContext implements Context
{
    /**
     * @var Application
     */
    private $application;
    /**
     * @var \Inviqa\Clearpay\Api\Response\Checkout\Create
     */
    private $result;
    /**
     * @var \Services\HttpRecorder
     */
    private $httpRecorder;

    public function __construct(string $cassettePath)
    {
        $config = new HttpMockConfig($cassettePath);
        $this->httpRecorder = $config->httpRecorder();
        $this->application = new Application($config);
    }

    /**
     * @When I request a checkout
     */
    public function iDispatchACreateCheckoutRequest()
    {
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

        $this->httpRecorder->insertCassette('create_checkout.yml');
        $this->result = $this->application->createCheckout($params);
    }

    /**
     * @Then I should receive a token
     */
    public function iShouldReceiveACheckoutToken()
    {
        Assert::assertNotEmpty($this->result->token());
    }

    /**
     * @Then I should receive an expiry date
     */
    public function iShouldReceiveAnExpiryDate()
    {
        Assert::assertInstanceOf(
            \DateTimeInterface::class,
            $this->result->expires()
        );
    }
}
