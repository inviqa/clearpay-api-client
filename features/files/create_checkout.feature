@end2end
Feature: Initiate Clearpay payment process by creating a checkout

    Scenario: Create a successful checkout
        When I request a checkout
        Then I should receive a token
        And I should receive an expiry date
