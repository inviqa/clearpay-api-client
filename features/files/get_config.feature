Feature: Get config request is made to the Clearpay deferred payment gateway

    Scenario: Minimum and Maximum configuration properties are returned
        When I make a get configuration call
        Then I should have "10.00" as a "minimum" amount
        And I should have "1000.00" as a "maximum" amount
        And I should have "GBP" as the currency
