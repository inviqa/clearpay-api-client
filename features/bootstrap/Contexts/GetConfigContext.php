<?php

namespace Contexts;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Inviqa\Clearpay\Application;
use Inviqa\Clearpay\Http\Response\ConfigurationResponse;
use PHPUnit\Framework\Assert;

class GetConfigContext implements Context
{
    /**
     * @var Application
     */
    private $application;

    private $response;
    /**
     * @var \Services\HttpRecorder
     */
    private $httpRecorder;

    public function __construct(string $cassettePath)
    {
        $config = new \Services\TestConfig($cassettePath);
        $this->httpRecorder = $config->httpRecorder();
        $this->application = new Application($config);
    }

    /**
     * @When I make a get configuration call
     */
    public function iMakeAGetConfigurationCall()
    {
        $this->httpRecorder->insertCassette('get_configuration.yml');

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
