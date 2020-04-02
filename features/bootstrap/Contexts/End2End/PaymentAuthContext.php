<?php

namespace Contexts\End2End;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Inviqa\Clearpay\Application;
use Inviqa\Clearpay\Exception\ClientErrorHttpException;
use PHPUnit\Framework\Assert;
use Services\TestConfig;

class PaymentAuthContext implements Context
{
    /**
     * @var Application
     */
    private $application;
    /**
     * @var string
     */
    private $clearpayErrorCode;
    /**
     * @var string
     */
    private $checkoutToken;

    public function __construct()
    {
        $this->application = new Application(new TestConfig);
    }

    /**
     * @Given I have a fresh checkout token
     */
    public function iHaveAFreshCheckoutToken()
    {
        $this->checkoutToken = $this->application->createCheckout(
            $this->createCheckoutParams()
        )->token();
    }

    /**
     * @Given I have checkout token :token
     */
    public function iHaveCheckoutToken(string $token = '')
    {
        $this->checkoutToken = $token;
    }

    /**
     * @When I make a payment auth request
     */
    public function iMakeAPaymentAuthRequest()
    {
        try {
            $this->paymentAuthResult = $this->application->paymentAuth(
                $this->checkoutToken,
                null,
                null
            );
        }
        catch (ClientErrorHttpException $e) {
            $this->clearpayErrorCode = $e->clearpayErrorCode();
        }
    }

    /**
     * @Then I should have an :errorCode error
     */
    public function iShouldHaveAnError($errorCode)
    {
        Assert::assertEquals($errorCode, $this->clearpayErrorCode);
    }

    private function createCheckoutParams()
    {
        return [
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
    }
}
