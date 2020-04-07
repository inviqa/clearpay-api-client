<?php

namespace Contexts\Integration;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Inviqa\Clearpay\Application;
use Inviqa\Clearpay\Api\Response\ConfigurationResponse;
use PHPUnit\Framework\Assert;

class GetConfigContext implements Context
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @var ConfigurationResponse
     */
    private $response;
    /**
     * @var \Services\HttpRecorder
     */
    private $httpRecorder;

    public function __construct(string $cassettePath)
    {
        $config = new \Services\HttpMockConfig($cassettePath);
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
     * @Then I should have :amount as a :absolute amount
     */
    public function IShouldHaveAnAbsoluteAmount($amount, $absolute = 'minimum')
    {
        if ($absolute === 'minimum') {
            Assert::assertEquals($amount, $this->response->getMinimumAmount());
            return;
        }

        Assert::assertEquals($amount, $this->response->getMaximumAmount());
    }

    /**
     * @Then I should have :code as the currency
     */
    public function iShouldHaveAsTheCurrency($code)
    {
        Assert::assertEquals($code, $this->response->getCurrencyCode());
    }
}
