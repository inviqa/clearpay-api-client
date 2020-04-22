Feature: Merchant can void funds from Clearpay Order

    Scenario: Void the remaining funds in a partially captured order.
        Given I have Order Id "400123851803"
        When I void the open to capture amount in the order
        Then I should have an "APPROVED" payment status
        And I should have an "VOIDED" payment state

    Scenario: Payment has already been fully captured
        Given I have Order Id "400123851788"
        When I void the open to capture amount in the order
        Then I should have an "payment_captured" error

    Scenario: Empty Order Id was passed to endpoint
        Given I have Order Id ""
        When I void the open to capture amount in the order
        Then I should have an "not_found" error

    Scenario: Fake Order Id was passed to endpoint
        Given I have Order Id "12345678998"
        When I void the open to capture amount in the order
        Then I should have an "error" error
