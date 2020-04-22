Feature: Merchant can void funds from Clearpay Order

    Scenario: Void the remaining funds in a partially captured order.
        Given I have Order Id "400123851542"
        When I void the open to capture amount in the order
        Then I should have an "APPROVED" payment status
        And I should have an "AUTH_APPROVED" payment state
