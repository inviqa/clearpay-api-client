<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Inviqa\Clearpay\Application;
use Inviqa\Clearpay\Http\Response\ConfigurationResponse;
use PHPUnit\Framework\Assert;
use Inviqa\Clearpay\Services\TestConfig;

class GetConfigContext implements Context
{
    /**
     * @var Application
     */
    private $application;

    private $response;

    public function __construct()
    {
        $this->application = new Application(new TestConfig());
    }

    /**
     * @When I make a get configuration call
     */
    public function iMakeAGetConfigurationCall()
    {
        /** @var ConfigurationResponse response */
        $this->response = $this->application->getConfiguration();
    }

    /**
     * @Then the response should be successful
     */
    public function theResponseShouldBeSuccessful()
    {
        Assert::assertTrue($this->response->isSuccessful());
    }

    /**
     * @Then I should receive a config response
     */
    public function iShouldReceiveAConfigResponse()
    {
        Assert::assertInstanceOf(ConfigurationResponse::class, $this->response);
    }

    /**
     * @Then the config response should contain a minimum and maximum order value
     */
    public function theConfigResponseShouldContainAMinimumAndMaximumOrderValue()
    {
        Assert::assertNotEmpty($this->response->getMinimumAmount());
        Assert::assertNotEmpty($this->response->getMaximumAmount());
    }
}