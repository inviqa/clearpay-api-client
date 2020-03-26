<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Inviqa\Clearpay\Application;
use Inviqa\Clearpay\Http\Response\ConfigurationResponse;
use PHPUnit\Framework\Assert;
use Inviqa\Clearpay\Services\TestConfig;

class CreateCheckoutContext implements Context
{
    /**
     * @var Application
     */
    private $application;

    public function __construct(string $username, string $password)
    {
        $this->application = new Application(new TestConfig($username, $password));
    }


    /**
     * @When I dispatch a create checkout request
     */
    public function iDispatchACreateCheckoutRequest()
    {
        $this->application->createCheckout();
    }
}
