<?php

namespace Contexts\Integration;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Inviqa\Clearpay\Api\Response\Payment\Payment;
use Inviqa\Clearpay\Api\Response\Payment\Refund;
use Inviqa\Clearpay\Application;
use Inviqa\Clearpay\Exception\HttpException;
use PHPUnit\Framework\Assert;
use Services\HttpMockConfig;

class PaymentOrderContext implements Context
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
     * @var null|string
     */
    private $requestId = null;
    /**
     * @var null|string
     */
    private $merchantRef = null;
    /**
     * @var string
     */
    private $clearpayErrorCode;
    /** @var Refund */
    private $resultRefund;
    /** @var Payment */
    private $resultPayment;
    /**
     * @var string
     */
    private $orderId;
    /**
     * @var string
     */
    private $orderStatus;

    public function __construct(string $cassettePath)
    {
        $config = new HttpMockConfig($cassettePath);
        $this->httpRecorder = $config->httpRecorder();
        $this->application = new Application($config);
    }

    /**
     * @Given I have Order Id :orderId
     */
    public function iHaveOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @Given I have checkout token :token
     */
    public function iHaveCheckoutToken(string $token = '')
    {
        $this->token = $token;
    }

    /**
     * @Given I have Order Id :orderId with a status of :orderStatus
     */
    public function iHaveOrderIdWithAStatusOf($orderId, $orderStatus)
    {
        $this->orderId = $orderId;
        $this->orderStatus = $orderStatus;
    }

    /**
     * @Given I have Request Id :requestId
     */
    public function iHaveRequestId($requestId)
    {
        $this->requestId = $requestId;
    }

    /**
     * @Given I have merchant reference :merchantRef
     */
    public function iHaveMerchantReference($merchantRef)
    {
        $this->merchantRef = $merchantRef;
    }

    /**
     * @Given I have have request id :requestId
     */
    public function iHaveHaveRequestId($requestId = null)
    {
        $this->requestId = $requestId;
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
     * @When I request a :amount refund in :currency for the order
     */
    public function iRequestARefundInForTheOrder($amount, $currency)
    {
        try {
            $this->httpRecorder->insertCassette('payment_refund.yml');
            $this->resultRefund = $this->application->paymentRefund(
                $this->orderId,
                $amount,
                $currency,
                $this->requestId,
                $this->merchantRef,
                $refundMerchantRef = null
            );
            $this->httpRecorder->eject();
        }
        catch (HttpException $e) {
            $this->clearpayErrorCode = $e->clearpayErrorCode();
        }
    }

    /**
     * @When I capture :amount in :currency for the order
     */
    public function iCaptureTheOrderFunds($amount, $currency)
    {
        try {
            $this->httpRecorder->insertCassette('payment_capture.yml');
            $this->resultPayment = $this->application->paymentCapture(
                $this->orderId,
                $amount,
                $currency
            );
            $this->httpRecorder->eject();
        }
        catch (HttpException $e) {
            $this->clearpayErrorCode = $e->clearpayErrorCode();
        }
    }

    /**
     * @When I make a payment auth request
     */
    public function iMakeAPaymentAuthRequest()
    {
        try {
            $this->httpRecorder->insertCassette('payment_auth.yml');
            $this->resultPayment = $this->application->paymentAuth(
                $this->token,
                $this->requestId,
                $this->merchantRef
            );
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
        Assert::assertEquals(
            $paymentStatus,
            $this->resultPayment->status()
        );
    }

    /**
     * @Then I should have an :paymentState payment state
     */
    public function iShouldHaveAnPaymentState($paymentState)
    {
        Assert::assertEquals(
            $paymentState,
            $this->resultPayment->paymentState()
        );
    }

    /**
     * @Then I should have been refunded :amount in :currency
     */
    public function iShouldHaveBeenRefundedInForOrderId($amount, $currency)
    {
        Assert::assertEquals($amount, $this->resultRefund->amount()->amount());
        Assert::assertEquals($currency, $this->resultRefund->amount()->currency());
    }

    /**
     * @Then I should have an :errorCode error
     */
    public function iShouldHaveAnError($errorCode)
    {
        Assert::assertEquals($errorCode, $this->clearpayErrorCode);
    }
}
