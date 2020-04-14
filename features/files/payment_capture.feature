Feature: Merchant can capture funds from Clearpay

    Scenario: Payment has already been fully captured for this order, or partially captured with the remainder voided.
        Given I have Order Id "400123851542"
        When I capture "30.00" in "GBP" for the order
        Then I should have an "APPROVED" payment status
        And I should have an "CAPTURED" payment state

    Scenario: Payment has already been fully captured for this order, or partially captured with the remainder voided.
        Given I have Order Id "123456789101112"
        When I capture "10.00" in "GBP" for the order
        Then I should have an "payment_captured" error

    Scenario: Order was declined by Clearpay; no payment can be captured for this order.
        Given I have Order Id "400123851541"
        When I capture "10.00" in "GBP" for the order
        Then I should have an "invalid_state" error

    Scenario: Auth for this order has already been completely voided
        Given I have Order Id "400123851422"
        When I capture "10.00" in "GBP" for the order
        Then I should have an "payment_voided" error
