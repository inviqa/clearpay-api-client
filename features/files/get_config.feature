Feature: A get config API request is made to the Clearpay deferred payment gateway

    Scenario: Config object is successfully retrieved from Clearpay
        When I make a get configuration call
        Then I should receive a config response
        And the response should be successful
        And the config response should contain a minimum and maximum order value
