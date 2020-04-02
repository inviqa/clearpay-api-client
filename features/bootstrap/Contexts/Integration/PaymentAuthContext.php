<?php

namespace Contexts\Integration;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Inviqa\Clearpay\Application;
use Inviqa\Clearpay\Exception\ClientErrorHttpException;
use Inviqa\Clearpay\Exception\HttpException;
use PHPUnit\Framework\Assert;
use Services\HttpMockConfig;
use Services\TestConfig;

class PaymentAuthContext implements Context
{
    /**
     * @var Application
     */
    private $application;
    /**
     * @var \Services\HttpRecorder
     */
    private $httpRecorder;
    /**
     * @var string
     */
    private $token;
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $result;
    /**
     * @var string
     */
    private $clearpayErrorCode;

    public function __construct(string $cassettePath)
    {
        $config = new HttpMockConfig($cassettePath);
        $this->httpRecorder = $config->httpRecorder();
        $this->application = new Application($config);
    }

    /**
     * @Given I have a fresh checkout token
     */
    public function iHaveAFreshCheckoutToken()
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

        $this->httpRecorder->insertCassette('payment_auth.yml');
        $this->token = $this->application->createCheckout($params)->token();
        $this->httpRecorder->eject();
    }

    /**
     * @Given I have checkout token :token
     */
    public function iHaveCheckoutToken(string $token = '')
    {
        $this->token = $token;
    }

    /**
     * @When I make a payment auth request
     */
    public function iMakeAPaymentAuthRequest()
    {
        try {
            $this->httpRecorder->insertCassette('payment_auth.yml');
            $this->result = $this->application->paymentAuth($this->token);
            $this->httpRecorder->eject();
        }
        catch (HttpException $e) {
            $this->clearpayErrorCode = $e->clearpayErrorCode();
        }
    }

    /**
     * @Then I should have an :paymentStatus payment status
     */
    public function iShouldHaveAnPaymentStatus($paymentStatus)
    {
        Assert::assertEquals('APPROVED', $paymentStatus);
    }

    /**
     * @Then I should have an :paymentState payment state
     */
    public function iShouldHaveAnPaymentState($paymentState)
    {
        Assert::assertEquals('AUTH_APPROVED', $paymentState);
    }

    /**
     * @Then I should have an :errorCode error
     */
    public function iShouldHaveAnError($errorCode)
    {
        Assert::assertEquals($errorCode, $this->clearpayErrorCode);
    }
}
