Feature: Initiate Clearpay full / partial order refund

    Scenario: Order is not found
        Given I have Order Id "order-001"
        And I have Request Id "req-id"
        And I have Merchant Reference "merchant-001-not-found"
        When I request a "10.00" refund in "GBP" for the order
        Then I should have an "not_found" error

    Scenario: The order is not eligible for a refund
        Given I have Order Id "order-001"
        And I have Request Id "req-id"
        And I have Merchant Reference "merchant-002-eligible"
        When I request a "10.00" refund in "GBP" for the order
        Then I should have an "precondition_failed" error

    Scenario: Refund amount exceeds available amount
        Given I have Order Id "order-002"
        And I have Request Id "req-id"
        And I have Merchant Reference "merchant-003-available-limit"
        When I request a "10000.00" refund in "GBP" for the order
        Then I should have an "invalid_amount" error

    Scenario: Refund currency does not match order currency
        Given I have Order Id "order-003"
        And I have Request Id "req-id"
        And I have Merchant Reference "merchant-003-currency-missmatch"
        When I request a "10.00" refund in "USD" for the order
        Then I should have an "unsupported_currency" error
